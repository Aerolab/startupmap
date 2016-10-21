/*



                                ./(((((((((((/*
                             /((((((((((((((((((((*
                          /((((((((((((((((((((((((((,
                        *((((((((((((((((((((((((((((((.
                      ,((((((((((((((((((((((((((((((((((
                     ,((((((((((((((((((((((((((((((((((((
                    .((((((((((((((((((((((((((((((((((((((
                    (((((((((((((((         (((((((((((((((,
                   *((((((((((((((            ((((((((((((((
                   /(((((((((((((             ((((((((((((((.
                   /(((((((((((((             ((((((((((((((.
                   ,((((((((((((((           ((((((((((((((/
                    /((((((((((((((         (((((((((((((((.
                    .((((((((((((((((((((((((((((((((((((((
                     .((((((((((((((((((((((((((((((((((((.
                      (((((((((((((((((((((((((((((((((((.
                      .((((((((((((((((((((((((((((((((((
                       .((((((((((((((((((((((((((((((((
                        .((((((((((((((((((((((((((((((
                         /((((((((((((((((((((((((((((,
                          (((((((((((((((((((((((((((.
                           (((((((((((((((((((((((((/ ,
                       /(( .(((((((((((((((((((((((. ,((.
                      ((((/  (((((((((((((((((((((/  ((((.
                    .((((((. .(((((((((((((((((((/ .(((((((
                   (((((((((. ,((((((((((((((((((  (((((((((.
                 .(((((((((((. ,(((((((((((((((/  /(((((((((((
                 .((((((((((((  .((((((((((((((  .((((((((((((
                 .((((((((((((,  .((((((((((((   /(((((((((((/
                  ((((((((((,     ,((((((((((      /(((((((((,
                  .((((((/         ,(((((((/         ,(((((((
                  .((((.            .(((((/            ,((((/
                   ((,               .(((/                /(,
                                      .(/                                      

                                  StartupMap.la
                            made with <3 by Aerolab
*/

function updateGeolocation()
{
	if($('#geoLocationAddress').val() != '' && $('#geoLocationCity').val() != '' && $('#geoLocationCountry').val() != '')
	{
		$.ajax({
			url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + ($('#geoLocationAddress').val() + ',' + $('#geoLocationCity').val() + ',' + $('#geoLocationCountry').val()) + '&sensor=true&component=country:' + $('#geoLocationCountry').val() + '&language=es',
			dataType: 'json',
			success: function(response){
				console.log(response);
				if(response.status != 'OK')
				{
					alert('Sorry, but we could\'t geo locate that address.');
				}
				else
				{
					$('#geoLocationLat').empty().val(response.results[0].geometry.location.lat);
					$('#geoLocationLon').empty().val(response.results[0].geometry.location.lng);
				}
			}
		});
	}
}

$(document).ready(function(){

	$('.confirmed-link').click(function(e){
		if( ! confirm('Are you sure you want to do this?'))
			return false;

		return true;
	});

	if($('#geoLocationAddress').size() != 0)
	{
		updateGeolocation();

		// Update GeoLocation
		$('.updateGeolocation').change(function(e){
			updateGeolocation();
		});
	}

	// Ajax file uploads
	$('.ajaxFileUpload').each(function(){
		var uploadRoute = $(this).attr('data-upload-route');
		var uploadField = $('#' + $(this).attr('data-upload-field'));
		var uploadInput = $('#' + $(this).attr('data-upload-input'));
		var uploadDropzone = $('.dropzone', $(this));

		if(uploadField.val() != '')
		{
			uploadDropzone.empty().css('background-image', 'url(/uploads/' + uploadField.val() + ')');
		}
		
		var fileUploader = $(this).fileupload({
			url: window.env.endpoint + uploadRoute, 
			fileInput: uploadInput,
			dropZone: uploadDropzone,
			dataType: 'json',
			type: 'POST',
			success: function(e, data){
				if(e.status == 'error')
				{
					alert(e.error);
					return false;
				}
				uploadField.empty().val(e.file.name);
				uploadDropzone.empty().css('background-image', 'url(' + e.file.path + ')');

				return false;
			},
			fail: function(){
				alert(e.error); 
				return false;
			}
		});

		fileUploader.bind('fileuploaddragover', function(e, data){
			uploadDropzone.addClass('drag-over');
			setTimeout(function(){
				uploadDropzone.removeClass('drag-over');
			}, 4000)
		}); 

		fileUploader.bind('fileuploadsubmit', function(e, data){
			uploadDropzone.removeClass('drag-over');
			uploadDropzone.addClass('uploading');
		});

		fileUploader.bind('fileuploaddone', function(e, data){
			uploadDropzone.removeClass('drag-over, uploading');
		});
	});

});
//End Document Ready
