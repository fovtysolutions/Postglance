
<head>
    <style>
        .dashboard-icon{
	font-size: 20px;
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

<div class="d-none sub-sidebar d-flex flex-column flex-row-auto" style="height: 100%;">

    <div class="d-flex mb-10  p-l-10 p-r-20 m-b-12">
    <div class="sidebar-nav sidebar-nav-one d-flex flex-column flex-column-fluid w-100 pt-lg-0 hide-x-scroll">
            <ul class="nav flex-column">
             <li class="nav-item custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="bi bi-send-check-fill dashboard-icon me-4" aria-hidden="true"></i>
                                    <span class="text-gray-600 fw-5" style="font-size:1.1rem">Single Post</span>
                                </a>
                            </li>
                           
                          
                            <li class="nav-item  custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard"  class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="bi bi-collection dashboard-icon me-4"></i>
                                    <span class="text-gray-600 fw-5" style="font-size:1.1rem">Bulk Post</span>
                                </a>
                            </li>
                            <li class="nav-item  custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-15 p-b-8 active text-primary">
                                <i class="bi bi-calendar3 dashboard-icon me-4" aria-hidden="true"></i>
                                    <span class="text-gray-600 fw-5" style="font-size:1.1rem">Calender</span>
                                </a>
                            </li>
                            <li class="nav-item  custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="bi bi-file-earmark-bar-graph dashboard-icon me-4" style="font-size:21px"></i>
                                    <span class="text-gray-600 fw-5" style="font-size:1.1rem">Draft</span>
                                </a>
                            </li>
                            <li class="nav-item  custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="bi bi-share-fill dashboard-icon me-3"></i>
                                    <span class="text-gray-600 fw-5" style="font-size:1.1rem">A/C Manager</span>
                                </a>
                            </li>
                            <li class="nav-item  custom-hover-effect">
                                <a href="<?=base_URL()?>/dashboard" class="nav-link d-flex p-t-12 p-b-8 active text-primary">
                                <i class="bi bi-folder-symlink dashboard-icon me-4"></i>
                                
                                    <span class="text-gray-600 fw-5" style="font-size:1.1rem">File Manager</span>
                                </a>
                            </li>
                           
                            
                     
                        
                            </ul>

        </div>
    </div>
</div>