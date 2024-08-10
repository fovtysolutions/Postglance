<?php if ( !empty($result) ): ?>
    
    <?php foreach ($result as $key => $value): ?>
        
        <tr class="item">
            <th scope="row" class="py-3 ps-4 border-bottom">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input checkbox-item" type="checkbox" name="ids[]" value="<?php _e( $value->ids )?>">
                </div>
            </th>
            <td class="border-bottom">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-50px overflow-hidden me-3">
                        <a href="<?php _e( get_module_url('index/update/'.$value->ids) )?>" class="actionItem" data-remove-other-active="true" data-active="bg-light-primary" data-result="html" data-content="main-wrapper" data-history="<?php _e( get_module_url('index/update/'.$value->ids) )?>">
                            <div class="symbol-label b-r-10" style="background-color: <?php _ec( get_data($value, "color") )?>">
                                <i class="<?php _ec( $value->icon )?> fs-20"></i>
                            </div>
                        </a>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="<?php _e( get_module_url('index/update/'.$value->ids) )?>" class="text-gray-800 text-hover-primary actionItem" data-remove-other-active="true" data-active="bg-light-primary" data-result="html" data-content="main-wrapper" data-history="<?php _e( get_module_url('index/update/'.$value->ids) )?>"><?php _ec( $value->name )?></a>
                    </div>
                </div>
            </td>
            <td class="border-bottom"><?php _ec( $value->content )?></td>
            <td class="border-bottom">
                <?php
                    switch ($value->status) {
                        case 0:
                            $status = '<span class="badge badge-light-warning fw-4 fs-12 p-6">'.__("Inactive").'</span>';
                            break;

                        default:
                            $status = '<span class="badge badge-light-success fw-4 fs-12 p-6">'.__("Active").'</span>';
                            break;
                    }

                ?>

                <?php _ec( $status )?>
            </td>
            <td class="text-end border-bottom text-nowrap py-4 pe-4">
                <div class="dropdown dropdown-fixed dropdown-hide-arrow">
                    <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fad fa-th-list pe-0"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="<?php _ec( get_module_url("popup_add_prompt/".$value->category_ids."/".$value->ids) )?>" class="actionItem dropdown-item" data-popup="addPromptTemplate" >
                                <i class="fad fa-pen-square pe-2"></i> <?php _e('Edit')?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php _e( get_module_url('delete_prompt/'.$value->ids) )?>" class="actionItem dropdown-item" data-confirm="<?php _e('Are you sure to delete this items?')?>" data-remove="item" data-active="bg-light-primary">
                                <i class="fad fa-trash-alt pe-2"></i> <?php _e("Delete")?>
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>

    <?php endforeach ?>

<?php endif ?>
