
<head>
<style>
.sidebars {
   
    display: flex;
    flex-direction: column;
    margin-top:116px;
   
}

.tab-button {
    background-color: #f5f8fa;
    color: #7E8299;
    border: none;
    padding: 14px;
    text-align: left;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    display: flex;
    align-items: center;
}

.tab-button .icon {
    margin-right: 10px;
}

.tab-button:hover {
    background-color: rgba(255, 219, 193, 0.5);
}

.tab-button.active {
    background-color: rgba(255, 219, 193, 0.5);
}

.tab-content {
    flex-grow: 1;
    padding: 20px;
}

.tab {
    display: none;
}

.tab.active {
    display: block;
}
.sub-sidebar {
    min-width: 4rem;
     max-width: 4rem;
   border-right: none; 
     /* box-shadow: 0 0 80px 50px rgb(206 213 225 / 12%);   */
    position: relative;
    height: fit-content;
    background-color: #f5f8fa;
    
}
@media (max-width: 768px) {
    .sub-sidebar {
        position: absolute;
    }
}

    </style>
</head>

<div class="sidebars sub-sidebar active">
        <button class="tab-button active" id="media-click" style="border-top-right-radius: 20px;">
            <i class="icon bi bi-camera2 dashboard-icon me-4"></i>
         
        </button>
        <button class="tab-button" id="link-click">
            <i class="icon bi bi-link-45deg dashboard-icon me-4"></i>
           
        </button>
        <button class="tab-button" id="text-click" style="border-bottom-right-radius: 20px;">
            <i class="icon bi bi-textarea-t dashboard-icon me-4"></i>
          
        </button>
    </div>
   
    <script>
        $(document).ready( function() {
            $('#media').show();
            $('#link').hide();
            $('#text').hide();
            $('#link-content').hide();
            $('#text-content').hide();
            $('#text-card-content').hide();
            $('#media-content').show();

            $('#media-click').click( function() {
                $('#link-click').removeClass("active");
                $('#media-click').addClass("active");
                $('#text-click').removeClass("active");
                $('#media').show();
                $('#link').hide();
                $('#text').hide();
                $('#link-content').hide();
                $('#text-content').hide();
                $('#text-card-content').hide();
                $('#media-content').show();
            })
            $('#link-click').click( function() {
                $('#link-click').addClass("active");
                $('#media-click').removeClass("active");
                $('#text-click').removeClass("active");
                $('#media').hide();
                $('#link').show();
                $('#text').hide();
                $('#link-content').show();
                $('#text-content').hide();
                $('#text-card-content').hide();
                $('#media-content').hide();
            })
            $('#text-click').click( function() {
                $('#link-click').removeClass("active");
                $('#media-click').removeClass("active");
                $('#text-click').addClass("active");
                $('#media').hide();
                $('#link').hide();
                $('#text').show();
                $('#link-content').hide();
                $('#text-content').show();
                $('#text-card-content').show();
                $('#media-content').hide();
            })
        })
    </script>
    