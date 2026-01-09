<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;

/**
 * Admin Role Controller
 * 
 * Handles role management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class RoleController extends BaseController
{
    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }

    /**
     * Display list of roles
     */
    public function index()
    {
        $data = [
            'title' => 'Roles Management',
            'roles' => $this->roleModel->findAll()
        ];

        return view('admin/roles/index', $data);
    }

    /**
     * Show create role form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Role',
            'availablePermissions' => $this->getAvailablePermissions()
        ];

        return view('admin/roles/create', $data);
    }

    /**
     * Store new role
     */
    public function store()
    {
        // Debug: Log all POST data
        log_message('debug', 'Role store POST data: ' . print_r($this->request->getPost(), true));
        
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[50]|is_unique[roles.name]',
            'description' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => strtolower($this->request->getPost('name')),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $roleId = $this->roleModel->insert($data);
        
        if ($roleId) {
            // Handle permissions
            $permissions = $this->request->getPost('permissions') ?? [];
            log_message('debug', 'Creating role with permissions: ' . json_encode($permissions));
            log_message('debug', 'Permissions type: ' . gettype($permissions));
            log_message('debug', 'Permissions is_array: ' . (is_array($permissions) ? 'true' : 'false'));
            
            $this->assignPermissionsToRole($roleId, $permissions);
            
            return redirect()->to('/admin/roles')->with('success', 'Role created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create role');
    }

    /**
     * Show edit role form
     */
    public function edit($id)
    {
        $role = $this->roleModel->find($id);
        
        if (!$role) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Role not found');
        }

        // Get role permissions
        $rolePermissions = $this->getRolePermissions($id);
        log_message('debug', 'Role permissions from DB: ' . print_r($rolePermissions, true));
        
        $role['permissions'] = array_column($rolePermissions, 'id');
        log_message('debug', 'Extracted permission IDs: ' . print_r($role['permissions'], true));

        $data = [
            'title' => 'Edit Role',
            'role' => $role,
            'availablePermissions' => $this->getAvailablePermissions()
        ];

        return view('admin/roles/edit', $data);
    }

    /**
     * Update role
     */
    public function update($id)
    {
        $role = $this->roleModel->find($id);
        
        if (!$role) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Role not found');
        }

        // Debug: Log all POST data
        log_message('debug', 'Role update POST data: ' . print_r($this->request->getPost(), true));
        
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => "required|min_length[3]|max_length[50]|is_unique[roles.name,id,{$id}]",
            'description' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => strtolower($this->request->getPost('name')),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->roleModel->update($id, $data)) {
            // Handle permissions
            $permissions = $this->request->getPost('permissions') ?? [];
            log_message('debug', 'Updating role ' . $id . ' with permissions: ' . json_encode($permissions));
            log_message('debug', 'Permissions type: ' . gettype($permissions));
            log_message('debug', 'Permissions is_array: ' . (is_array($permissions) ? 'true' : 'false'));
            
            $this->assignPermissionsToRole($id, $permissions);
            
            return redirect()->to('/admin/roles')->with('success', 'Role updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update role');
    }

    /**
     * Delete role
     */
    public function delete($id)
    {
        $role = $this->roleModel->find($id);
        
        if (!$role) {
            return redirect()->to('/admin/roles')->with('error', 'Role not found');
        }

        // Check if role is being used by users
        $userModel = new \App\Models\UserModel();
        $hasUsers = $userModel->where('role_id', $id)->countAllResults() > 0;
        
        if ($hasUsers) {
            return redirect()->to('/admin/roles')->with('error', 'Cannot delete role that is assigned to users');
        }

        // Prevent deletion of system roles
        $systemRoles = ['admin', 'manager', 'user'];
        if (in_array($role['name'], $systemRoles)) {
            return redirect()->to('/admin/roles')->with('error', 'Cannot delete system roles');
        }

        if ($this->roleModel->delete($id)) {
            return redirect()->to('/admin/roles')->with('success', 'Role deleted successfully');
        }

        return redirect()->to('/admin/roles')->with('error', 'Failed to delete role');
    }

    /**
     * Toggle role status
     */
    public function toggleStatus($id)
    {
        $role = $this->roleModel->find($id);
        
        if (!$role) {
            return $this->response->setJSON(['success' => false, 'message' => 'Role not found']);
        }

        $newStatus = $role['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->roleModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Get available permissions from database
     */
    private function getAvailablePermissions(): array
    {
        $permissionModel = new \App\Models\PermissionModel();
        return $permissionModel->getAllGroupedByCategory();
    }

    /**
     * Assign permissions to role
     */
    public function assignPermissions($id)
    {
        $role = $this->roleModel->find($id);
        
        if (!$role) {
            return $this->response->setJSON(['success' => false, 'message' => 'Role not found']);
        }

        $permissions = $this->request->getPost('permissions') ?? [];
        
        if ($this->assignPermissionsToRole($id, $permissions)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Permissions updated successfully']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update permissions']);
    }

    /**
     * Helper method to assign permissions to a role
     */
    private function assignPermissionsToRole(int $roleId, array $permissionIds): bool
    {
        $db = \Config\Database::connect();
        
        try {
            // Debug: Log the incoming data with more detail
            log_message('debug', 'assignPermissionsToRole called with roleId: ' . $roleId);
            log_message('debug', 'Raw permissions data: ' . print_r($permissionIds, true));
            log_message('debug', 'Permissions count: ' . count($permissionIds));
            
            $db->transStart();
            
            // Remove existing permissions
            $deleteResult = $db->table('role_permissions')->where('role_id', $roleId)->delete();
            log_message('debug', 'Deleted existing permissions for role ' . $roleId . ', result: ' . ($deleteResult ? 'true' : 'false'));
            
            // Add new permissions
            if (!empty($permissionIds)) {
                $data = [];
                foreach ($permissionIds as $index => $permissionId) {
                    log_message('debug', "Processing permission {$index}: {$permissionId} (type: " . gettype($permissionId) . ")");
                    
                    // Validate permission ID is numeric
                    if (is_numeric($permissionId)) {
                        $data[] = [
                            'role_id' => $roleId,
                            'permission_id' => (int)$permissionId,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        log_message('debug', "Added permission {$permissionId} to batch");
                    } else {
                        log_message('debug', "Skipped non-numeric permission: {$permissionId}");
                    }
                }
                
                log_message('debug', 'Final data array: ' . print_r($data, true));
                
                if (!empty($data)) {
                    $insertResult = $db->table('role_permissions')->insertBatch($data);
                    $affectedRows = $db->affectedRows();
                    log_message('debug', 'Insert result: ' . ($insertResult ? 'true' : 'false'));
                    log_message('debug', 'Affected rows: ' . $affectedRows);
                    log_message('debug', 'Inserted ' . count($data) . ' permissions for role ' . $roleId);
                } else {
                    log_message('debug', 'No valid permissions to insert for role ' . $roleId);
                }
            } else {
                log_message('debug', 'No permissions provided for role ' . $roleId);
            }
            
            $db->transComplete();
            
            $status = $db->transStatus();
            log_message('debug', 'Transaction status for role ' . $roleId . ': ' . ($status ? 'success' : 'failed'));
            
            // Final verification - check what was actually saved
            $savedPerms = $db->table('role_permissions')->where('role_id', $roleId)->get()->getResultArray();
            log_message('debug', 'Final saved permissions: ' . print_r($savedPerms, true));
            
            return $status;
        } catch (\Exception $e) {
            log_message('error', 'Failed to assign permissions: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Get role permissions for editing
     */
    private function getRolePermissions(int $roleId): array
    {
        $permissionModel = new \App\Models\PermissionModel();
        return $permissionModel->getForRole($roleId);
    }
}