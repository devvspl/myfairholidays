<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'email', 
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[255]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'subject' => 'required|min_length[5]|max_length[200]',
        'message' => 'required|min_length[10]|max_length[2000]',
        'status' => 'in_list[new,read,replied,closed]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 2 characters long',
            'max_length' => 'Name cannot exceed 100 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'max_length' => 'Email cannot exceed 255 characters'
        ],
        'phone' => [
            'required' => 'Phone number is required',
            'min_length' => 'Phone number must be at least 10 digits',
            'max_length' => 'Phone number cannot exceed 20 characters'
        ],
        'subject' => [
            'required' => 'Subject is required',
            'min_length' => 'Subject must be at least 5 characters long',
            'max_length' => 'Subject cannot exceed 200 characters'
        ],
        'message' => [
            'required' => 'Message is required',
            'min_length' => 'Message must be at least 10 characters long',
            'max_length' => 'Message cannot exceed 2000 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get validation rules for public contact form (excluding status)
     */
    public function getPublicValidationRules()
    {
        return [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[255]',
            'phone' => 'required|min_length[10]|max_length[20]',
            'subject' => 'required|min_length[5]|max_length[200]',
            'message' => 'required|min_length[10]|max_length[2000]'
        ];
    }

    /**
     * Get validation messages for public contact form
     */
    public function getPublicValidationMessages()
    {
        return [
            'name' => [
                'required' => 'Name is required',
                'min_length' => 'Name must be at least 2 characters long',
                'max_length' => 'Name cannot exceed 100 characters'
            ],
            'email' => [
                'required' => 'Email is required',
                'valid_email' => 'Please enter a valid email address',
                'max_length' => 'Email cannot exceed 255 characters'
            ],
            'phone' => [
                'required' => 'Phone number is required',
                'min_length' => 'Phone number must be at least 10 digits',
                'max_length' => 'Phone number cannot exceed 20 characters'
            ],
            'subject' => [
                'required' => 'Subject is required',
                'min_length' => 'Subject must be at least 5 characters long',
                'max_length' => 'Subject cannot exceed 200 characters'
            ],
            'message' => [
                'required' => 'Message is required',
                'min_length' => 'Message must be at least 10 characters long',
                'max_length' => 'Message cannot exceed 2000 characters'
            ]
        ];
    }
    public function getContacts($filters = [], $perPage = 20)
    {
        // Apply filters
        if (!empty($filters['status'])) {
            $this->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $this->groupStart()
                 ->like('name', $filters['search'])
                 ->orLike('email', $filters['search'])
                 ->orLike('subject', $filters['search'])
                 ->orLike('message', $filters['search'])
                 ->groupEnd();
        }

        if (!empty($filters['date_from'])) {
            $this->where('created_at >=', $filters['date_from'] . ' 00:00:00');
        }

        if (!empty($filters['date_to'])) {
            $this->where('created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    /**
     * Get contact statistics
     */
    public function getStats()
    {
        return [
            'total' => $this->countAll(),
            'new' => $this->where('status', 'new')->countAllResults(false),
            'read' => $this->where('status', 'read')->countAllResults(false),
            'replied' => $this->where('status', 'replied')->countAllResults(false),
            'closed' => $this->where('status', 'closed')->countAllResults(false),
            'today' => $this->where('DATE(created_at)', date('Y-m-d'))->countAllResults(false),
            'this_week' => $this->where('created_at >=', date('Y-m-d', strtotime('-7 days')))->countAllResults(false),
            'this_month' => $this->where('MONTH(created_at)', date('m'))
                               ->where('YEAR(created_at)', date('Y'))
                               ->countAllResults(false)
        ];
    }

    /**
     * Mark contact as read
     */
    public function markAsRead($id)
    {
        return $this->update($id, ['status' => 'read']);
    }

    /**
     * Mark contact as replied
     */
    public function markAsReplied($id)
    {
        return $this->update($id, ['status' => 'replied']);
    }

    /**
     * Mark contact as closed
     */
    public function markAsClosed($id)
    {
        return $this->update($id, ['status' => 'closed']);
    }

    /**
     * Get recent contacts
     */
    public function getRecentContacts($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}