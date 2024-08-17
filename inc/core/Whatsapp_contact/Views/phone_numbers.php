<form>
    <div class="container align-items-md-center pt-4 align-items-center justify-content-center mw-800 mb-5">
        <div class="bd-search position-relative me-auto">
            <h2 class="mb-0 py-4"> <i class="fad fa-address-book me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e( get_data($contact, "name") )?></h2>
        </div>
        <div class="">
            <div class="dropdown me-2">
                <div class="input-group sp-input-group border b-r-4">
                    <span class="input-group-text border-0 fs-20 bg-gray-100 text-gray-800" id="sub-menu-search"><i class="fad fa-search"></i></span>
                    <input type="text" class="ajax-pages-search ajax-filter form-control form-control-solid ps-15 border-0" name="keyword" value="" placeholder="Search" autocomplete="off">
                    <a href="<?php _ec( get_module_url("popup_import_contact/".get_data($contact, "ids")) )?>" class="btn btn-light btn-active-light-primary actionItem border-end m-r-1" data-popup="ImportContactModal"><i class="fad fa-file-import"></i> <?php _e("Import")?></a>
                    <a href="<?php _e( get_module_url("delete_phone") )?>" class="btn btn-light border-end btn-active-light-danger m-r-1 actionMultiItem" data-confirm="<?php _e('Are you sure to delete this items?')?>" data-call-success="Core.ajax_pages();"><i class="fal fa-trash-alt"></i></a>
                    <a href="<?php _ec( get_module_url() )?>" class="btn btn-light btn-active-light-dark"><i class="fad fa-chevron-left"></i> <?php _e("Back")?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mw-800">
        <div 
                class="ajax-pages" 
                data-url="<?php _ec( get_module_url("ajax_list_phone_numbers/".get_data($contact, "id")) )?>" 
                data-response=".ajax-result" 
                data-per-page="<?php _ec( get_data($datatable, "per_page") )?>"
                data-current-page="<?php _ec( get_data($datatable, "current_page") )?>"
                data-total-items="<?php _ec( get_data($datatable, "total_items") )?>"
            >

            <div class="card">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <td class="w-20 border-bottom p-12">
                                <div class="form-check form-check-sm form-check-custom form-check-solid position-relative mn-t-4">
                                    <input class="form-check-input checkbox-all" type="checkbox">
                                </div>
                            </td>
                            <td class="fw-6 text-uppercase p-12 border-bottom w-80"><?php _e("No.")?></td>
                            <td class="fw-6 text-uppercase p-12 border-bottom w-200"><?php _e("Phone number")?></td>
                            <td class="fw-6 text-uppercase p-12 border-bottom"><?php _e("Params")?></td>
                        </tr>
                    </thead>
                    <tbody class="ajax-result">
                        <td class="p-12" colspan="4">
                            <div class="mw-200 container d-flex align-items-center align-self-center h-100 py-5">
                                <div>
                                    <div class="text-center px-4">
                                        <img class="mw-100 mh-300px" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty2.png">
                                    </div>
                                </div>
                            </div>
                        </td> 
                    </tbody>
                </table>
            </div>

            <nav class="m-t-50 m-b-50 ajax-pagination m-auto text-center"></nav>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function(){
        Core.ajax_pages();
    });
</script>

