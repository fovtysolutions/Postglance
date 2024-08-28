
<div class="row mb-5 mt-2">
	<div class="col-md-12">
		<div class="card mb-4  px-4 shadow-none border b-r-10" style="background-color:#FEF4EA!important">
			<div class="card-title fw-5 fs-19 text-gray-800 text-center pt-4">
				<span class="me-2"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAAjCAYAAAAe2bNZAAAACXBIWXMAAAsTAAALEwEAmpwYAAADI0lEQVR4nO2WX4hUVRzHbxY9WK5E4mMW9VCLhXJ/5w6zu7WgqVvkUsIgc8/v7uoY5mp/NAx92FqqBwehkCXZQPfBghRDe1AKUYsSFCGM/mgEtWpaWS6VEUQjez5x7zpLszMb0szu7MN+4Qv3nt/h/j6c8zu/ezxvSlOaxCLTeDNqNpE16TpCZG7E+k9h/QFyDxZYGTROPITn3YA1T2DNGaLUn6xrg5XpMxMPoqYNldNY+YMVadi8HLoWFojMmomD6PSbUfkUlV9RA7lm3LaNsKEdVC6Qa5ox/hChfz8qR7AymEDEfrIV92Y3dOvwu5UPxhciSt1HJEex5pcRiNhdD+OO7IYXo+LYb2iwYJwg/DtQ2Y+Vn0sgYj/zCO7trbi+boiC4qoM0ONNqy2EpmcT+v2o/FgGEXvDUty7b+Deyif1cm3codJbO4jI3I7KDqz5YfjjlUDacee/wu3KJ9s0Mm7lJzr8u6uHyDTeisoW1HyPNUMVIWJvzuCO7cd9cQyeby+NWfm8epBQerDmLNYUxoSI/XIOd/gd3DcnYVNmdPxvNHi6OpAebxpW3is5qqMdBbgtXbiP9+GO7kmey+fJBWzQUPXKxCKbehQ132HlakmSjhQuvw538WvcR3txvRshSlWCOeTVUqz2p6OmH2suJwk607jXn8MNfIY7fXy4seVaKoFcoSNYXFOYosiaJXEhJ0f3w724wXO43dtg7aIx6knO1ry3/FuosUMnDroE5ttT8OxjYxe2Sp9XrdD596DB42T8meUxPzV0YOdfSZ28suq/QC6R9e+tDiRsuW34IhQ0YOWFuM+UxLP+LPpf/d29vyv5EV5LXCCUK6W9xXxZFchIpw1lefKca5pBJMvK5uS7LrnX1sdJr2LlIlZeotO0Yc0pbDCIlQKRrK8aJklmJVe8d6BmRVl87eLzrFlwGSt59IFbSmKaWoSaTypt8f+DaW29CZXVqMyNC7YsHpqHapbsuqFCMw8124n8lqSgrVlI6DdPKERRdKburFvy0UKDVePatK4bJOsHqDTVmyNubPGJaKs3h0c4fw4a3FVvjilNWv0DXX3Bt+iiFOYAAAAASUVORK5CYII="><?php _e("Report posts")?></span>
			</div>
			<form class="actionForm" action="<?php _e( base_url("post/report/".uri("segment", 4)) )?>" method="POST" data-result="html" data-content="insights" date-redirect="false" data-loading="false">
				<div class="pt-3">
					<div class="card-header px-0 border-bottom-0 card-toolbar">
						<div class="me-3 py-2">
							<select name="social_network" data-control="select2" data-hide-search="true" class="form-select form-select-sm bg-body fw-bold border border-dashed miw-150 auto-submit">
								<option value="all" data-icon="fas fa-share-alt-square text-dark" selected><?php _e("All Report")?></option>
								<?php if (!empty( $result )): ?>
									<?php foreach ($result as $value): ?>
										<?php if ( isset($value['parent']['id']) ): ?>
										<option value="<?php _e( $value['parent']['id'] )?>" data-icon="<?php _e( $value['icon'] )?>" data-icon-color="<?php _e( $value['color'] )?>"><?php _e( $value['name'] )?></option>
										<?php endif ?>
									<?php endforeach ?>
								<?php endif ?>
							</select>
						</div>
						<div class="daterange dashed radius py-2 text-gray-100"></div>
					</div>
				</div>
			</form>
			<?php include  __DIR__."/../cache.php" ;?>
		</div>
	</div>
</div>



