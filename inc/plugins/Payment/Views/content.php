<div class="payment-wrap w-100 h-100 overflow-auto">
    <div class="m-auto mw-800 py-5 px-4">
        <div class="mb-5 w-100">
            <img src="<?php _ec( get_option("website_logo_color", base_url("assets/img/logo-color.svg")) )?>" class="h-45 mb-4">
            <h1 class="text-dark fs-30 text-gray-800"><?php _e( sprintf("Subscribe to %s plan", $plan->name) )?></h1>
            <div class="text-gray-600"><?php _e( $plan->desc )?></div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label class="border b-r-10 bg-white p-30 w-100 bg-hover-light-primary" for="bill_type_monthly">
                    <div class="d-flex justify-content-between">
                        <div class="fw-6 fs-16"><?php _e("Bill monthly")?></div>
                        <div>
                            <div class="form-check form-check-inline me-0">
                                <input class="form-check-input me-0 plan_by" type="radio" name="bill_type" id="bill_type_monthly" value="1" <?php _e( (uri("segment", 4)=="" || uri("segment", 4) == 1)?"checked":"" )?>>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-500 fs-12"><?php _e( sprintf("$%s/month", 12) )?></div>

                </label>
            </div>
            <div class="col">
                <label class="border b-r-10 bg-white p-30 w-100 bg-hover-light-primary" for="bill_type_yearly">
                    <div class="d-flex justify-content-between">
                        <div class="fw-6 fs-16"><?php _e("Bill yearly")?></div>
                        <div>
                            <div class="form-check form-check-inline me-0">
                                <input class="form-check-input me-0 plan_by" type="radio" name="bill_type" id="bill_type_yearly" value="2" <?php _e( (uri("segment", 4) == 2)?"checked":"" )?>>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-500 fs-12"><?php _e( sprintf("$%s/year", 12) )?></div>
                </label>
            </div>
        </div>

        <div class="mb-4 mt-5">
            <h2><i class="fad fa-percentage text-success me-2"></i> <?php _e("Coupon code")?></h2>
        </div>

        <div class="card card-shadow border b-r-10 mb-4 by_monthly">

            <?php 
            $coupon_code = "";

            if($plan->coupon){
                $coupon_code = $plan->coupon_info->code;
            }

            ?>

            <div class="card-body">
                <form class="actionForm" action="<?php _ec( get_module_url("coupon") )?>" data-redirect="">
                    <div class="input-group sp-input-group">
                        <input type="text" class="form-control form-control-solid" name="coupon_code" value="<?php _ec( $coupon_code )?>" placeholder="<?php _e("Enter coupon code")?>" autocomplete="off">
                        <button type="submit" class="btn btn-dark"><?php _e("Submit")?></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mb-4 mt-5">
            <h2><i class="fad fa-list text-primary me-2"></i> <?php _e("Payment details")?></h2>
        </div>

        <div class="card card-shadow border b-r-10 mb-4 by_monthly <?php _ec( uri("segment", 4)==2?"d-none":"" )?>">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td><?php _e("Subtotal")?></td>
                            <td class="text-end"><?php _e( sprintf("$%s", $plan->price_monthly_default) )?></td>
                        </tr>
                        <?php if ($plan->coupon): ?>
                            <tr class="text-danger">
                                <td><?php _e("Promotion")?></td>
                                <td class="text-end"><?php _e( sprintf("-$%s", $plan->price_monthly_coupon) )?></td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td><?php _e("Billed Now")?></td>
                            <td class="text-end fw-6 fs-18"><?php _e( sprintf("$%s", $plan->amount_monthly) )?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-shadow border b-r-10 mb-4 by_annually <?php _ec( (uri("segment", 4) == "" || uri("segment", 4) == 1)?"d-none":"" )?>">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td><?php _e("Subtotal")?></td>
                            <td class="text-end"><?php _e( sprintf("$%s", $plan->price_annually_default) )?></td>
                        </tr>
                        <tr class="text-danger">
                            <td><?php _e("Annually plan discount")?></td>
                            <td class="text-end"><?php _e( sprintf("-$%s", $plan->price_save) )?></td>
                        </tr>
                        <?php if ($plan->coupon): ?>
                            <tr class="text-danger">
                                <td><?php _e("Promotion")?></td>
                                <td class="text-end"><?php _e( sprintf("-$%s", $plan->price_annually_coupon) )?></td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td><?php _e("Billed Now")?></td>
                            <td class="text-end fw-6 fs-18"><?php _e( sprintf("$%s", $plan->amount_annually) )?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-4 mt-5">
            <h2><i class="fad fa-credit-card text-danger me-2"></i> <?php _e("Payment methods")?></h2>
        </div>

        <div class="row">
            <?php if (!empty($items)): ?>
                
                <?php foreach ($items as $key => $value): ?>
                    
                    <?php _ec($value['data']['html'])?>

                <?php endforeach ?>

            <?php endif ?>
        </div>
    </div>
</div>
