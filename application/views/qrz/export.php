<div class="container adif" id="qrz_export">

	<h2><?php echo $page_title; ?></h2>

	<div class="card">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs pull-right" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="export-tab" data-bs-toggle="tab" href="#export" role="tab" aria-controls="import" aria-selected="true">Upload Logbook</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="mark-tab" data-bs-toggle="tab" href="#import" role="tab" aria-controls="import" aria-selected="false">Download QSOs</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="mark-tab" data-bs-toggle="tab" href="#mark" role="tab" aria-controls="export" aria-selected="false">Mark QSOs</a>
				</li>
			</ul>

		</div>

		<div class="card-body">
			<div class="tab-content">
				<div class="tab-pane active" id="export" role="tabpanel" aria-labelledby="export-tab">
					<p>Here you can see and upload all QSOs which have not been previously uploaded to a QRZ logbook.</p>
					<p>You need to set a QRZ Logbook API key in your station profile. Only station profiles with an API Key set are displayed.</p>
					<p><span class="badge text-bg-warning">Warning</span> This might take a while as QSO uploads are processed sequentially.</p>

					<?php
					if ($station_profile->result()) {
						echo '

            <table class="table table-bordered table-hover table-striped table-condensed text-center">
                <thead>
                <tr>
                    <td>Profile name</td>
                    <td>Station callsign</td>
                    <td>Edited QSOs not uploaded</td>
                    <td>Total QSOs not uploaded</td>
                    <td>Total QSOs uploaded</td>
                    <td>Actions</td>
                </thead>
                <tbody>';
						foreach ($station_profile->result() as $station) {      // Fills the table with the data
							echo '<tr>';
							echo '<td>' . $station->station_profile_name . '</td>';
							echo '<td>' . $station->station_callsign . '</td>';
							echo '<td id ="modcount' . $station->station_id . '">' . $station->modcount . '</td>';
							echo '<td id ="notcount' . $station->station_id . '">' . $station->notcount . '</td>';
							echo '<td id ="totcount' . $station->station_id . '">' . $station->totcount . '</td>';
							echo '<td><button id="qrzUpload" type="button" name="qrzUpload" class="btn btn-primary btn-sm ld-ext-right ld-ext-right-' . $station->station_id . '" onclick="ExportQrz(' . $station->station_id . ')"><i class="fas fa-cloud-upload-alt"></i> Upload<div class="ld ld-ring ld-spin"></div></button></td>';
							echo '</tr>';
						}
						echo '</tfoot></table>';
					} else {
						echo '<div class="alert alert-danger" role="alert">Nothing found!</div>';
					}
					?>

				</div>
				<div class="tab-pane fade" id="import" role="tabpanel" aria-labelledby="home-tab">

					<form class="form" action="<?php echo site_url('qrz/import_qrz'); ?>" method="post" enctype="multipart/form-data">
						Download QSOs from QRZ Logbook for all Locations<br>
						<button type="submit" class="btn btn-sm btn-primary" value="Export">Download from QRZ Logbook</button>
					</form>
				</div>

				<div class="tab-pane fade" id="mark" role="tabpanel" aria-labelledby="home-tab">

					<form class="form" action="<?php echo site_url('qrz/mark_qrz'); ?>" method="post" enctype="multipart/form-data">
						<select name="station_profile" class="form-select mb-4 me-sm-4" style="width: 30%;">
							<option disabled value="0">Select Station Location</option>
							<?php foreach ($station_profiles->result() as $station) { ?>
								<option <?php if ($station->station_active) {
											echo "selected ";
										} ?>value="<?php echo $station->station_id; ?>">Callsign: <?php echo $station->station_callsign; ?> (<?php echo $station->station_profile_name; ?>)</option>
							<?php } ?>
						</select>
						<p><span class="badge text-bg-warning">Warning</span> If a date range is not selected then all QSOs will be marked!</p>
						<div class="row">
							<div class="col-md-2">
								<label for="from"><?php echo lang('gen_from_date') . ": " ?></label>
								<input name="from" id="from" type="date" class="form-control w-auto">
							</div>

							<div class="col-md-2">
								<label for="to"><?php echo lang('gen_to_date') . ": " ?></label>
								<input name="to" id="to" type="date" class="form-control w-auto">
							</div>
						</div>
						<br>
						<button type="submit" class="btn btn-sm btn-primary" value="Export">Mark QSOs as exported to QRZ Logbook</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>