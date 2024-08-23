<div class="row" id="alldata">
	<div class="col-md-4 mb-4">
        <div class="border rounded b-r-10 position-relative" style="background-color: rgba(255, 219, 193, 0.5) !important">
            <div class="p-20 position-relative zIndex-2 p-b-0 d-flex">
            	<div class="bg-light-primary w-60 h-60 text-primary m-auto d-flex align-items-center justify-content-center fs-30 b-r-10">
                	<i class="fad fa-badge-check"></i>
            	</div>
            	<div class="flex-grow-1 ms-3">
            		<div class=""><span class="fs-28 fw-9 text-primary me-1">0</span> <span class="fw-6 text-gray-700">Succeed</span></div>
            		<div class="fs-12 fw-5 text-gray-400">27-07-2024 - 23-08-2024</div>
            	</div>
            </div>
            <div id="post_by_status_succeed_chart" class="h-120 b-0 w-100"></div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="border rounded b-r-10 position-relative" style="background-color: rgba(255, 219, 193, 0.5) !important">
        	<div class="p-20 position-relative zIndex-2 p-b-0 d-flex">
            	<div class="bg-light-primary w-60 h-60 text-primary m-auto d-flex align-items-center justify-content-center fs-30 b-r-10">
                	<i class="fad fa-exclamation"></i>
            	</div>
            	<div class="flex-grow-1 ms-3">
            		<div class=""><span class="fs-28 fw-9 text-primary me-1">0</span> <span class="fw-6 text-gray-700">Failed</span></div>
            		<div class="fs-12 fw-5 text-gray-400">27-07-2024 - 23-08-2024</div>
            	</div>
            </div>
            <div id="post_by_status_failed_chart" class="h-120 b-0 w-100"></div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="border rounded b-r-10 position-relative" style="background-color: rgba(255, 219, 193, 0.5) !important">
        	<div class="p-20 position-relative zIndex-2 p-b-0 d-flex">
            	<div class="bg-light-primary w-60 h-60 text-primary m-auto d-flex align-items-center justify-content-center fs-30 b-r-10">
                	<i class="fad fa-calendar-check"></i>
            	</div>
            	<div class="flex-grow-1 ms-3">
            		<div class=""><span class="fs-28 fw-9 text-primary me-1">0</span> <span class="fw-6 text-gray-700">Total</span></div>
            		<div class="fs-12 fw-5 text-gray-400">27-07-2024 - 23-08-2024</div>
            	</div>
            </div>
	        <div id="post_by_status_total_chart" class="h-120 b-0 w-100"></div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-4 mb-4">
		<div class="card b-r-6 mb-4 border" style="background-color: rgba(255, 219, 193, 0.5) !important">
			<div class="card-header">
				<div class="card-title">
					Report post by status				</div>
			</div>
			<div class="card-body">
				<div id="post_by_status_chart"></div>
				<h3 class="text-center"></h3>
			</div>
		</div>
	</div>
	<div class="col-md-4 mb-4">
	    <div class="card h-100 mb-4 border" style="background-color: rgba(255, 219, 193, 0.5) !important">
	        <div class="card-header">
	            <div class="card-title">
	                <span class="me-2">Report post by type</span>
	            </div>
	        </div>
	        <div class="card-body">
	            <div id="post_by_type_chart"></div>
	            <div class="card border b-r-10 border">
	            	<div class="card-body">
	            		<div class="table-responsive">
	                        <table class="table align-middle">
	                            <thead class="border-bottom">
	                                <tr>
	                                    <th scope="col" class="text-center text-gray-500 fw-6"></th>
	                                    <th scope="col" class="text-center text-gray-500 fw-4 fs-12">Media</th>
	                                    <th scope="col" class="text-center text-gray-500 fw-4 fs-12">Link</th>
	                                    <th scope="col" class="text-center text-gray-500 fw-4 fs-12">Text</th>
	                                </tr>
	                            </thead>
	                            <tbody class="text-gray-700">
	                                <tr>
	                                	<td class="text-dark p-10 text-gray-500 fw-4 fs-12">Total post</td>
	                                	<td class="text-dark p-10 text-center fw-6">0</td>
	                                	<td class="text-dark p-10 text-center fw-6">0</td>
	                                	<td class="text-dark p-10 text-center fw-6">0</td>
	                                </tr>
	                            </tbody>
	                        </table>
	                    </div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-md-4 mb-4">
	    <div class="card h-100 mb-4 border" style="background-color: rgba(255, 219, 193, 0.5) !important">
	        <div class="card-header">
	            <div class="card-title">
	                <span class="me-2">Recent publications</span>
	            </div>
	        </div>
	        <div class="card-body py-0 px-4">
	        	<div class="schedules-main overflow-auto row mt-4 mh-600 h-100">
				    <div class="schedule-list h-100">
				    								<div class="w-100 h-100 d-flex justify-content-center align-items-center">
								<div class="text-center px-4">
						            <img class="mh-190 mb-4" alt="" src="http://localhost/Postglance/inc/themes/backend/Stackmin/Assets/img/empty2.png">
						            <div>
						            	<a class="btn btn-primary btn-sm b-r-30" href="http://localhost/Postglance/post" >
			                            	<i class="fad fa-plus"></i> Create post			                            </a>
						            </div>
						        </div>
							</div>							
						
				    </div>
	        	</div>
	        </div>
	    </div>
	</div>
</div>


<script type="text/javascript">
    $(function(){
    	Core.chart({
	        id: 'post_by_status_succeed_chart',
	        categories: ['Jul 27','Jul 28','Jul 29','Jul 30','Jul 31','Aug 1','Aug 2','Aug 3','Aug 4','Aug 5','Aug 6','Aug 7','Aug 8','Aug 9','Aug 10','Aug 11','Aug 12','Aug 13','Aug 14','Aug 15','Aug 16','Aug 17','Aug 18','Aug 19','Aug 20','Aug 21','Aug 22','Aug 23'],
	        legend: false,
	        stacking: false,
	        xvisible: false,
	        yvisible: false,
	        margin: [0,0,0,0],
	        data: [{
	        	type: 'areaspline',
	            name: 'Post succeed',
	            lineColor: 'rgba(80, 205, 127, 1)',
                color: {
	                linearGradient : {
	                    x1: 1,
	                    y1: 0,
	                    x2: 0,
	                    y2: 0
	                },
	                stops : [
	                    [0, 'rgba(80, 205, 127, 0.7)'],
	                    [1, 'rgba(80, 205, 127, 0)'],
	                ]
	            },
	            fillColor : {
	                linearGradient : {
	                    x1: 1,
	                    y1: 0,
	                    x2: 0,
	                    y2: 1
	                },
	                stops : [
	                    [0, 'rgba(80, 205, 127, 0.7)'],
	                    [1, 'rgba(80, 205, 127, 0)'],
	                ]
	            },
	            marker: {
	                enabled: false
	            },
	            data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	        }]
	    });

	    Core.chart({
	        id: 'post_by_status_failed_chart',
	        categories: ['Jul 27','Jul 28','Jul 29','Jul 30','Jul 31','Aug 1','Aug 2','Aug 3','Aug 4','Aug 5','Aug 6','Aug 7','Aug 8','Aug 9','Aug 10','Aug 11','Aug 12','Aug 13','Aug 14','Aug 15','Aug 16','Aug 17','Aug 18','Aug 19','Aug 20','Aug 21','Aug 22','Aug 23'],
	        legend: false,
	        stacking: false,
	        xvisible: false,
	        yvisible: false,
	        margin: [0,0,0,0],
	        data: [{
	        	type: 'areaspline',
	            name: 'Post failed',
	            lineColor: 'rgba(241, 65, 108, 1)',
                color: {
	                linearGradient : {
	                    x1: 1,
	                    y1: 0,
	                    x2: 0,
	                    y2: 0
	                },
	                stops : [
	                    [0, 'rgba(241, 65, 108, 0.7)'],
	                    [1, 'rgba(241, 65, 108, 0)'],
	                ]
	            },
	            fillColor : {
	                linearGradient : {
	                    x1: 1,
	                    y1: 0,
	                    x2: 0,
	                    y2: 1
	                },
	                stops : [
	                    [0, 'rgba(241, 65, 108, 0.7)'],
	                    [1, 'rgba(241, 65, 108, 0)'],
	                ]
	            },
	            marker: {
	                enabled: false
	            },
	            data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	        }]
	    });

	    Core.chart({
	        id: 'post_by_status_total_chart',
	        categories: ['Jul 27','Jul 28','Jul 29','Jul 30','Jul 31','Aug 1','Aug 2','Aug 3','Aug 4','Aug 5','Aug 6','Aug 7','Aug 8','Aug 9','Aug 10','Aug 11','Aug 12','Aug 13','Aug 14','Aug 15','Aug 16','Aug 17','Aug 18','Aug 19','Aug 20','Aug 21','Aug 22','Aug 23'],
	        legend: false,
	        stacking: false,
	        xvisible: false,
	        yvisible: false,
	        margin: [0,0,0,0],
	        data: [{
	        	type: 'areaspline',
	            name: 'Post failed',
	            lineColor: 'rgba(0, 148, 247, 1)',
                color: {
	                linearGradient : {
	                    x1: 1,
	                    y1: 0,
	                    x2: 0,
	                    y2: 0
	                },
	                stops : [
	                    [0, 'rgba(0, 148, 247, 0.7)'],
	                    [1, 'rgba(0, 148, 247, 0)'],
	                ]
	            },
	            fillColor : {
	                linearGradient : {
	                    x1: 1,
	                    y1: 0,
	                    x2: 0,
	                    y2: 1
	                },
	                stops : [
	                    [0, 'rgba(0, 148, 247, 0.7)'],
	                    [1, 'rgba(0, 148, 247, 0)'],
	                ]
	            },
	            marker: {
	                enabled: false
	            },
	            data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	        }]
	    });

        Core.column_chart({
	        id: 'post_by_status_chart',
	        categories: ['Jul 27','Jul 28','Jul 29','Jul 30','Jul 31','Aug 1','Aug 2','Aug 3','Aug 4','Aug 5','Aug 6','Aug 7','Aug 8','Aug 9','Aug 10','Aug 11','Aug 12','Aug 13','Aug 14','Aug 15','Aug 16','Aug 17','Aug 18','Aug 19','Aug 20','Aug 21','Aug 22','Aug 23'],
	        legend: true,
	        stacking: true,
	        xvisible: true,
	        yvisible: true,
	        data: [{
	        	type: 'column',
	            name: 'Post succeed',
	            lineColor: 'rgba(80, 205, 127, 1)',
                color: 'rgba(80, 205, 127, 1)',
	            marker: {
	                enabled: false
	            },
	            data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	        },
	        {
	        	type: 'column',
	            name: 'Post failed',
	            lineColor: 'rgba(241, 65, 108, 1)',
                color: 'rgba(241, 65, 108, 1)',
	            marker: {
	                enabled: false
	            },
	            data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
	        }]
	    });

	    Core.chart({
            id: 'post_by_type_chart',
            categories: '',
            legend: true,
            data: [{
                type: 'pie',
                name: 'Percent',
                data: [{
                    name: 'Media',
                    y: 0,
                    color: 'rgba(80, 205, 127, 0.7)',
                }, 
                {
                    name: 'Link',
                    y: 0,
                    color: 'rgba(241, 65, 108, 0.7)',
                },
                {
                    name: 'Text',
                    y: 0,
                    color: 'rgba(0, 148, 247, 0.7)',
                }],
                size: 250,
                innerSize: '60%',
                showInLegend: true,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });
</script>
