<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- Hero Section -->
<?php if (!empty($heroSection)): ?>
<section class="bg-cover position-relative" style="background:url(<?= base_url($heroSection['background_image'] ?? 'assets/images/home-img/bg.webp') ?>)no-repeat;" data-overlay="5">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-7 col-lg-9 col-md-12">
            <div class="fpc-capstion text-center my-4">
               <div class="fpc-captions">
                  <h1 class="xl-heading text-light"><?= esc($heroSection['title']) ?></h1>
                  <?php if (!empty($heroSection['subtitle'])): ?>
                  <p class="text-light fs-5"><?= esc($heroSection['subtitle']) ?></p>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="fpc-banner"></div>
</section>
<?php endif; ?>



<!-- Mission Section -->
<style>
    .mission-section {
  /*background: #fafafa;*/
}

.mission-title {
  font-size: clamp(28px, 3vw, 40px);
  line-height: 1.2;
}

.mission-subtitle {
  font-size: 18px;
  color: #6c757d;
}

.mission-content p {
  font-size: 16px;
  line-height: 1.7;
  margin-bottom: 12px;
  
}

.mission-image-wrap img {
  max-height: 420px;
  object-fit: cover;
}

/* Mobile Optimization */
@media (max-width: 767px) {
  .mission-content-wrap {
    text-align: center;
  }

  .mission-image-wrap {
    margin-top: 20px;
  }
}

</style>

<?php if (!empty($missionSection)): ?>
<section class="mission-section py-5">
   <div class="container">
      <div class="row align-items-center justify-content-between gy-4">
         
         <!-- Content -->
         <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="mission-content-wrap pe-xl-4">
               
               <h2 class="mission-title fw-bold mb-3">
                  <?= esc($missionSection['title']) ?>
               </h2>

               <?php if (!empty($missionSection['subtitle'])): ?>
               <h3 class="mission-subtitle mb-3">
                  <?= esc($missionSection['subtitle']) ?>
               </h3>
               <?php endif; ?>

               <?php if (!empty($missionSection['content'])): ?>
               <div class="mission-content ">
                  <?= $missionSection['content'] ?>
               </div>
               <?php endif; ?>

            </div>
         </div>

         <!-- Image -->
         <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="mission-image-wrap position-relative text-center">
               <img 
                  src="<?= base_url($missionSection['image_path'] ?? 'assets/images/side-3.webp') ?>" 
                  class="img-fluid rounded-4 shadow-sm"
                  alt="<?= esc($missionSection['title']) ?>"
               >
            </div>
         </div>

      </div>
   </div>
</section>
<?php endif; ?>



<!-- Stats Section -->
<style>
    /* =========================
   Stats Section Styling
========================= */

.gray {
    background: white!important;
}

.urfacts-wrap {
    background: #ffffff;
    border-radius: 14px;
    padding: 22px 18px;
    height: 100%;
    box-shadow: 0 8px 22px rgba(14, 21, 78, 0.08);
    transition: all 0.3s ease;
    border-left: 5px solid #fe8815;
}

.urfacts-wrap:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 32px rgba(14, 21, 78, 0.15);
}

.urfacts-first h3 {
    color: #0e154e!important;
    font-size: 40px;
    font-weight: 700;
    line-height: 1;
}

.urfacts-caps p {
    color: #555;
    font-size: 15px;
    font-weight: 500;
}

/* =========================
   Tablet View
========================= */
@media (max-width: 991px) {
    .urfacts-first h3 {
        font-size: 34px;
    }

    .urfacts-caps p {
        font-size: 14px;
    }
}

/* =========================
   Mobile View
========================= */
@media (max-width: 575px) {
    .urfacts-wrap {
        padding: 18px 14px;
        flex-direction: column;
        text-align: center;
        border-left: none;
        border-top: 4px solid #fe8815;
    }

    .urfacts-caps {
        padding-left: 0 !important;
        margin-top: 8px;
    }

    .urfacts-first h3 {
        font-size: 30px;
    }
}

</style>

<?php if (!empty($statsSection)): ?>
<section class="py-4 gray">
   <div class="container">
      <div class="row align-items-center justify-content-between g-4">
         <?php foreach ($statsSection as $stat): ?>
         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
            <div class="urfacts-wrap d-flex align-items-center justify-content-center">
               <div class="urfacts-first flex-shrink-0">
                  <h3 class="fs-1 fw-medium text-primary mb-0"><?= esc($stat['stat_value']) ?></h3>
               </div>
               <div class="urfacts-caps ps-3">
                  <p class="text-muted-2 lh-base mb-0"><?= $stat['stat_label'] ?></p>
               </div>
            </div>
         </div>
         <?php endforeach; ?>
      </div>
   </div>
</section>
<?php endif; ?>


<!---stactic section -->


<style>
    .what-we-do {
  padding: 50px 20px;
  background: #ffffff;
}

.wwd-container {
  max-width: 1200px;
  margin: auto;
  display: flex;
  align-items: center;
  gap: 60px;
}

/* IMAGE */
.wwd-image {
  position: relative;
  flex: 1;
}

.wwd-image img {
  width: 100%;
  border-radius: 10px;
}

/* EXPERIENCE BADGE */
.experience-badge {
  position: absolute;
  bottom: 20px;
  left: 20px;
  background: #fe8815;
  color: #fff;
  padding: 18px 22px;
  text-align: center;
  border-radius: 8px;
}

.experience-badge span {
  font-size: 28px;
  font-weight: 700;
  display: block;
}

/* CONTENT */
.wwd-content {
  flex: 1;
}

.wwd-content h2 {
  font-size: 36px;
  color: #0e154e;
  margin-bottom: 15px;
}

.wwd-desc {
  font-size: 16px;
  color: #6c757d;
  margin-bottom: 15px;
}

/* CHECK LIST */
.wwd-list {
  list-style: none;
  padding: 0;
  margin-bottom: 30px;
}

.wwd-list li {
  position: relative;
  padding-left: 40px;
  margin-bottom: 14px;
  font-size: 16px;
  color: #222;
}

.wwd-list li::before {
  content: "✔";
  position: absolute;
  left: 0;
  top: 0;
  width: 26px;
  height: 26px;
  background: #0e154e;
  color: #fff;
  border-radius: 50%;
  text-align: center;
  line-height: 26px;
  font-size: 14px;
}

/* BUTTON */
.wwd-btn {
  display: inline-block;
  padding: 12px 40px;
  background: #fe8815;
  color: #fff;
  text-decoration: none;
  border-radius: 6px;
  font-weight: 600;
  transition: 0.3s ease;
}

.wwd-btn:hover {
  background: #0e154e;
}

/* RESPONSIVE */
@media (max-width: 992px) {
  .wwd-container {
    flex-direction: column;
    gap: 40px;
  }

  .wwd-content h2 {
    font-size: 30px;
  }
}

@media (max-width: 576px) {
  .experience-badge {
    padding: 14px 16px;
  }

  .experience-badge span {
    font-size: 22px;
  }
}

</style>

<section class="what-we-do">
  <div class="wwd-container">
    
    <!-- Left Image -->
    <div class="wwd-image">
      <img src="https://seagreen-bee-691633.hostingersite.com/public/main/images/young-woman-taking-photo-with-her-phone-beautiful-mountain-view.jpg" alt="What We Do">
      <div class="experience-badge">
        <span>20+</span>
        <small>Years Experience</small>
      </div>
    </div>

    <!-- Right Content -->
    <div class="wwd-content">
      <h2>What We Do</h2>
      <p class="wwd-desc">
       Our expert team has travelled across the Indian territories and offers personal
       guidance to make sure that you could get the most out of your holiday. You may wish to:
</p>

      <ul class="wwd-list">
        <li>Ask us to book your accommodation</li>
        <li>Book a private transfer</li>
        <li>Take a multi-centre trip</li>
        <li>Take a customized Itinerary within India</li>
        <li>Pre-booked excursion or tickets for a sporting or cultural event in India.</li>
      </ul>

      <a href="#" class="wwd-btn">Read More</a>
    </div>

  </div>
</section>





<section class="what-we-do">
  <div class="wwd-container">
      
       <!-- Right Content -->
    <div class="wwd-content">
      <h2>How My Fair Holidays Work?</h2>
      <p class="wwd-desc">
       We are confident about our knowledge and flexibility and looks forward to assist you in achieving your dream vacation.
A comprehensive choice of accommodation
</p>
<p class="wwd-desc">
     We presents ample options of hotels and resorts throughout India
All round quality hotels from budget to 5 stars
Flexible timings Leisure Trips

</p>
<p class="wwd-desc">
      Be it hill stations, beaches and pilgrimages or even adventurous, cultural and historical in nature, My Fair Holidays specializes in organizing comfortable holidays in all parts of India. Providing LTC holidays to the public sector employees is again one of the important focal point of the company. For this purpose My Fair Holidays has tie-ups with all leading airlines and hotel chains to give the best deals ever in the industry.

</p>
      <a href="#" class="wwd-btn">Contact Now</a>
    </div>

    
    <!-- Left Image -->
    <div class="wwd-image">
      <img src="https://seagreen-bee-691633.hostingersite.com/public/main/images/young-woman-taking-photo-with-her-phone-beautiful-mountain-view.jpg" alt="What We Do">
     
    </div>

   
  </div>
</section>



<!-- Features Section -->
<?php if (!empty($featuresSection)): ?>
<section style="padding:70px 20px; background:#ffffff; font-family: Arial, sans-serif;">
   <div style="max-width:1200px; margin:auto; text-align:center;">
      <h2 style="font-size:36px; font-weight:700; margin-bottom:10px;">
         Why Choose My Fair Holidays?
      </h2>
      <p style="max-width:700px; margin:0 auto 50px; color:#666; line-height:1.6;">
         Personalized travel planning, flexible options, and trusted partnerships —
         everything you need for a stress-free holiday.
      </p>
      <div style="display:flex; gap:30px; flex-wrap:wrap; justify-content:center;">
         <?php foreach ($featuresSection as $feature): ?>
         <div style="flex:1; min-width:280px; max-width:360px; border:1px solid #e6e6e6; border-radius:14px; padding:30px; text-align:left;">
            <?php if (!empty($feature['icon'])): ?>
            <div style="width:55px; height:55px; background:#f1f6ff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px; font-size:24px;">
               <?= $feature['icon'] ?>
            </div>
            <?php endif; ?>
            <h4 style="font-size:20px; margin-bottom:10px;"><?= esc($feature['title']) ?></h4>
            <?php if (!empty($feature['content'])): ?>
            <div style="color:#666; line-height:1.6;">
               <?= $feature['content'] ?>
            </div>
            <?php endif; ?>
         </div>
         <?php endforeach; ?>
      </div>
   </div>
</section>
<?php endif; ?>


<!-- faq's section-->

<style>
    .faq-section {
  padding: 5px 20px;
  background: #ffffff;
}

.faq-container {
  max-width: 1250px;
  margin: auto;
}

/* HEADER */
.faq-header {
  text-align: center;
  margin-bottom: 50px;
}

.faq-header h2 {
  font-size: 36px;
  color: #0e154e;
  margin-bottom: 12px;
}

.faq-header p {
  font-size: 18px!important;
  color: #555;
 width: 100%;
  margin: auto;
}

/* GRID */
.faq-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
}

/* FAQ ITEM */
.faq-item {
  border: 1px solid #eee;
  border-radius: 8px;
  overflow: hidden;
}

.faq-question {
  width: 100%;
  padding: 14px 20px;
  background: #0e243a;
  color: #fff;
  border: none;
  text-align: left;
  font-size: 16px;
  font-weight:400;
  cursor: pointer;
  position: relative;
  margin-bottom: 5px;
}

.faq-question::after {
  content: "+";
  position: absolute;
  right: 20px;
  font-size: 20px;
}

.faq-item.active .faq-question {
  background: #fe8815;
}

.faq-item.active .faq-question::after {
  content: "−";
}

/* ANSWER */
.faq-answer {
  max-height: 0;
  overflow: hidden;
  background: #fafafa;
  padding: 0 20px;
  transition: all 0.3s ease;
  font-size: 15px;
  color: #333;
}

.faq-item.active .faq-answer {
  max-height: 200px;
  padding: 15px 20px;
}

/* RESPONSIVE */
@media (max-width: 992px) {
  .faq-grid {
    grid-template-columns: 1fr;
  }

  .faq-header h2 {
    font-size: 30px;
  }
}

</style>

<section class="faq-section">
  <div class="faq-container">

    <!-- Heading -->
    <div class="faq-header">
      <h2>Frequently Asked Questions</h2>
      <p>
        Find quick answers to common questions about our services, process,
        and how we help businesses grow effectively.
      </p>
    </div>

    <!-- FAQ GRID -->
    <div class="faq-grid">

      <!-- LEFT -->
      <div class="faq-column">
        <div class="faq-item">
          <button class="faq-question">What services do you provide?</button>
          <div class="faq-answer">
            We offer web development, UI/UX design, SEO-optimized builds, and scalable digital solutions.
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Are your solutions mobile-friendly?</button>
          <div class="faq-answer">
            Yes, all our projects are fully responsive and tested across devices.
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Do you provide custom solutions?</button>
          <div class="faq-answer">
            Absolutely. Every solution is tailored according to business goals and requirements.
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Do you offer post-launch support?</button>
          <div class="faq-answer">
            Yes, we provide complete technical support and maintenance after project delivery.
          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="faq-column">
        <div class="faq-item">
          <button class="faq-question">How long does a project take?</button>
          <div class="faq-answer">
            Project timelines depend on scope, but most projects are delivered within 2–6 weeks.
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Is SEO included in development?</button>
          <div class="faq-answer">
            Yes, we follow SEO-friendly coding standards to ensure better search visibility.
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Can you redesign existing websites?</button>
          <div class="faq-answer">
            Yes, we specialize in redesigning outdated websites for better performance and UX.
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">How can I get started?</button>
          <div class="faq-answer">
            You can contact us through our website form and our team will connect with you.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<script>
  document.querySelectorAll(".faq-question").forEach(btn => {
    btn.addEventListener("click", () => {
      const item = btn.parentElement;
      item.classList.toggle("active");
    });
  });
</script>

<!--- ended -->


<!--- logos section -->
<style>
    .linked-section{
  padding: 70px 20px;
  background: #fff;
}

.linked-container{
  max-width: 1200px;
  margin: 0 auto;
}

.linked-head{
  text-align: center;
  margin-bottom: 35px;
}

.linked-title{
  color: #0e154e;
  font-size: 34px;
  font-weight: 800;
  letter-spacing: 1px;
  margin: 0 0 10px;
  position: relative;
  display: inline-block;
  padding-bottom: 10px;
}



.linked-subtitle{
  width:100%;
  margin: 0 auto;
  color: #555;
  font-size: 17px!important;
  line-height: 1.7;
}

/* Logos Grid */
.linked-logos{
  margin-top: 30px;
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 18px;
}


.logo-card{
  background: #fff;
  border: 1px solid #eef0f6;
  border-radius: 10px;
  min-height: 92px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 18px;
  text-decoration: none;
  position: relative;
  transition: 0.25s ease;
  overflow: hidden;
}


.logo-card::before{
  content:"";
  position:absolute;
  left:0;
  top:0;
  width:5px;
  height:100%;
  background:#fe8815;
  opacity: 0.9;
}

.logo-card img{
  max-width: 100%;
  max-height: 46px;
  object-fit: contain;
  
  transition: 0.25s ease;
}

/* Hover */
.logo-card:hover{
  border-color: rgba(14,21,78,0.25);
  box-shadow: 0 10px 22px rgba(14,21,78,0.08);
  transform: translateY(-3px);
}

.logo-card:hover img{
  filter: grayscale(0%);
  opacity: 1;
}

/* Responsive */
@media (max-width: 1100px){
  .linked-logos{ grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 650px){
  .linked-logos{ grid-template-columns: repeat(2, 1fr); }
  .linked-title{ font-size: 28px; }
}
@media (max-width: 420px){
  .linked-logos{ grid-template-columns: 1fr; }
}

</style>

<section class="linked-section">
  <div class="linked-container">

    <div class="linked-head">
      <h2 class="linked-title">We Are Linked With</h2>
      <p class="linked-subtitle">
        We also provide hotel booking, flight booking, train ticketing, visa transaction, and web solution services.
      </p>
    </div>

    <div class="linked-logos">
      <!-- Replace image paths with your real logos -->
      <a href="#" class="logo-card">
        <img src="https://www.myfairholidays.com/Content/images/about/testimonials/default-logo.png" alt="Partner 1">
      </a>

      <a href="#" class="logo-card">
        <img src="https://www.myfairholidays.com/Content/images/about/testimonials/Incredible_India_campaign_logo.png" alt="Partner 2">
      </a>

      <a href="#" class="logo-card">
        <img src="https://www.myfairholidays.com/Content/images/about/testimonials/default-logo.png" alt="Partner 3">
      </a>

      <a href="#" class="logo-card">
        <img src="https://www.myfairholidays.com/Content/images/about/testimonials/default-logo.png" alt="Partner 4">
      </a>

      <a href="#" class="logo-card">
        <img src="https://www.myfairholidays.com/Content/images/about/testimonials/default-logo.png" alt="Partner 5">
      </a>

      <a href="#" class="logo-card">
        <img src="https://www.myfairholidays.com/Content/images/about/testimonials/default-logo.png" alt="Partner 6">
      </a>
    </div>

  </div>
</section>





<!-- ended-->


<style>
.mission-content p {
    margin-bottom: 1rem;
    line-height: 1.6;
}

.mission-content h1, .mission-content h2, .mission-content h3, 
.mission-content h4, .mission-content h5, .mission-content h6 {
    color: #333;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.mission-content ul, .mission-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.mission-content li {
    margin-bottom: 0.25rem;
}

.mission-content strong {
    font-weight: 600;
    color: #333;
}

.mission-content em {
    font-style: italic;
}

.mission-content a {
    color: #007bff;
    text-decoration: none;
}

.mission-content a:hover {
    text-decoration: underline;
}
</style>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>