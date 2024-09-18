
<head>
<style>



.dashboard-icon{
	font-size: 20px;
    color: #ff5c35;
}

.text-gray-600 {
    color: var(--sp-text-gray-600) !important;
   margin-left: 0rem !important; 
  
   
}
.custom-hover-effect {
    position: relative;
    transition: background-color 0.3s ease-in-out;
    background-color: rgba(255, 219, 193, 0.5);
    border-radius: 5px;
}

.custom-hover-effect:hover {
    background-color: rgba(255, 219, 193, 0.5); /* #FFDBC1 with 50% transparency */
    border-radius: 5px; /* Optional: Add border-radius for smooth edges */
}


    </style>
</head>


<div class="sub-sidebar d-flex flex-column flex-row-auto" style="height: 100%;">
    <div class="p-20 d-flex mb-10  p-l-10 p-r-20 m-b-12">
        <div class="sidebar-nav sidebar-nav-one d-flex flex-column flex-column-fluid w-100 pt-lg-0 hide-x-scroll">
                        <ul class="nav flex-column">
                            <li class="nav-item custom-hover-effect" id="media-click">
                                    <a  href="#" class="nav-link d-flex p-t-12 p-b-8  text-primary">
                                    <i class="icon bi bi-camera2 dashboard-icon me-4" aria-hidden="true"></i>
                                        <span class="text-gray-600 fw-5" style="font-size:1.1rem">Media</span>
                                    </a>
                                </li>                           
                                <li class="nav-item " id="link-click">
                                    <a href="#"  class="nav-link d-flex p-t-12 p-b-8  text-primary">
                                    <i class="icon bi bi-link-45deg dashboard-icon me-4"></i>
                                        <span class="text-gray-600 fw-5" style="font-size:1.1rem">Link</span>
                                    </a>
                                </li>
                                <li class="nav-item " id="text-click">
                                    <a href="#" class="nav-link d-flex p-t-15 p-b-8 text-primary">
                                    <i class="icon bi bi-textarea-t dashboard-icon me-4" aria-hidden="true"></i>
                                        <span class="text-gray-600 fw-5" style="font-size:1.1rem">Text</span>
                                    </a>
                                </li>
                               
                             
                        </ul>

        </div>
    </div>
</div>
    <script>
	$(document).ready( function(){	
		$('#media-click').click( function(){
			$('#media').click();
            $(this).addClass('custom-hover-effect');
            $('#link-click').removeClass('custom-hover-effect');
            $('#text-click').removeClass('custom-hover-effect');

            
	    })
		$('#link-click').click( function(){
			$('#link').click();
            $(this).addClass('custom-hover-effect');
            $('#media-click').removeClass('custom-hover-effect');
            $('#text-click').removeClass('custom-hover-effect');

	    })
		$('#text-click').click( function(){
			$('#text').click();
            $(this).addClass('custom-hover-effect');
            $('#media-click').removeClass('custom-hover-effect');
            $('#link-click').removeClass('custom-hover-effect');
	    })
	})

    $(document).ready( function(){	
		$('#media').click( function(){

            $('#media-click').addClass('custom-hover-effect');
            $('#link-click').removeClass('custom-hover-effect');
            $('#text-click').removeClass('custom-hover-effect');
            
            
	    })
		$('#link').click( function(){
			
            $('#link-click').addClass('custom-hover-effect');
            $('#media-click').removeClass('custom-hover-effect');
            $('#text-click').removeClass('custom-hover-effect');

	    })
		$('#text').click( function(){
			
            $('#text-click').addClass('custom-hover-effect');
            $('#media-click').removeClass('custom-hover-effect');
            $('#link-click').removeClass('custom-hover-effect');
	    })
	})
</script>
