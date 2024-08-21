
<head>
    <style>
        .dashboard-icon{
	font-size: 24px;
    color: #ff5c35;
}
.text-gray-600 {
    color: var(--sp-text-gray-600) !important;
   margin-left: 0rem !important; */
  
}
.custom-hover-effect {
    position: relative;
    transition: background-color 0.3s ease-in-out;
}

.custom-hover-effect:hover {
    background-color: rgba(255, 219, 193, 0.5); /* #FFDBC1 with 50% transparency */
    border-radius: 5px; /* Optional: Add border-radius for smooth edges */
}

    </style>
</head>

<div class="sub-sidebar d-flex flex-column flex-row-auto" style="height: 100%;">

    <div class="d-flex mb-10  p-l-10 p-r-20 m-b-12">
    <div class="sidebar-nav sidebar-nav-one d-flex flex-column flex-column-fluid w-100 pt-lg-3 hide-x-scroll">
            <ul class="nav flex-column">
             <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="fa fa-paper-plane dashboard-icon me-4" aria-hidden="true"></i>
                                    <span class="text-gray-600 fw-5">Publish</span>
                                </a>
                            </li>
                           
                          
                            <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="far fa-calendar-alt dashboard-icon me-4"></i>
                                    <span class="text-gray-600 fw-5">Schedule</span>
                                </a>
                            </li>
                            <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="bi bi-rocket-takeoff dashboard-icon me-4" aria-hidden="true"></i>
                                    <span class="text-gray-600 fw-5">Free Trial</span>
                                </a>
                            </li>
                            <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="	fas fa-user-astronaut dashboard-icon me-4" style="font-size:21px"></i>
                                    <span class="text-gray-600 fw-5">Open AI</span>
                                </a>
                            </li>
                            <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="fas fa-users dashboard-icon me-3"></i>
                                    <span class="text-gray-600 fw-5">Team</span>
                                </a>
                            </li>
                            <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="fab fa-firstdraft dashboard-icon me-4"></i>
                                
                                    <span class="text-gray-600 fw-5">Draft</span>
                                </a>
                            </li>
                            <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                              
                                <i class="fa fa-camera-retro dashboard-icon me-4" aria-hidden="true"></i>
                                    <span class="text-gray-600 fw-5">Media</span>
                                </a>
                            </li>
                            <li class="nav-item mb-2 custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                              
                               
                                <i class="fa fa-text-height dashboard-icon me-4" aria-hidden="true"></i>
                                    <span class="text-gray-600 fw-5">Text</span>
                                </a>
                            </li>
                     
                        
                            </ul>

        </div>
    </div>
</div>