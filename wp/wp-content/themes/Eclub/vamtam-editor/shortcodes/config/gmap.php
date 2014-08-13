<?php
return array(
	'name' => __('Google Maps', 'church-event') ,
	'desc' => __('In order to enable Google Map you need:<br>
                 Insert the Google Map element into the editor, open its option panel by clicking on the icon- edit on the right of the element and fill in all fields nesessary.
' , 'church-event'),
		'icon' => array(
		'char' => WPV_Editor::get_icon('location1'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'gmap',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __('Address (optional)', 'church-event') ,
			'desc' => __('Unless you\'ve filled in the Latitude and Longitude options, please enter the address that you want to be shown on the map. If you encounter any errors about the maximum number of address translation requests per page, you should either use the latitude/longitude options or upgrade to the paid Google Maps API.', 'church-event'),
			'id' => 'address',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Latitude', 'church-event') ,
			'desc' => __('This option is not necessary if an address is set.<br/><br/>', 'church-event'),
			'id' => 'latitude',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Longitude', 'church-event') ,
			'desc' => __('This option is not necessary if an address is set.<br/><br/>', 'church-event'),
			'id' => 'longitude',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Zoom', 'church-event') ,
			'desc' => __('Default map zoom level.<br/><br/>', 'church-event'),
			'id' => 'zoom',
			'default' => '14',
			'min' => 1,
			'max' => 19,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __('Marker', 'church-event') ,
			'desc' => __('Enable an arrow pointing at the address.<br/><br/>', 'church-event'),
			'id' => 'marker',
			'default' => true,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('HTML', 'church-event') ,
			'desc' => __('HTML code to be shown in a popup above the marker.<br/><br/>', 'church-event'),
			'id' => 'html',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Popup Marker', 'church-event') ,
			'desc' => __('Enable to open the popup above the marker by default.<br/><br/>', 'church-event'),
			'id' => 'popup',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Controls (optional)', 'church-event') ,
			'desc' => sprintf(__('This option is intended to be used only by advanced users and is not necessary for most use cases. Please refer to the <a href="%s" title="Google Maps API documentation">API documentation</a> for details.', 'church-event'), 'https://developers.google.com/maps/documentation/javascript/controls'),
			'id' => 'controls',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Scrollwheel', 'church-event') ,
			'id' => 'scrollwheel',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Maptype (optional)', 'church-event') ,
			'id' => 'maptype',
			'default' => 'ROADMAP',
			'options' => array(
				'ROADMAP' => __('Default road map', 'church-event') ,
				'SATELLITE' => __('Google Earth satellite', 'church-event') ,
				'HYBRID' => __('Mixture of normal and satellite', 'church-event') ,
				'TERRAIN' => __('Physical map', 'church-event') ,
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Scrollwheel', 'church-event') ,
			'id' => 'scrollwheel',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Color (optional)', 'church-event') ,
			'desc' => __('Defines the overall hue for the map. It is advisable that you avoid gray colors, as they are not well-supported by Google Maps.', 'church-event'),
			'id' => 'hue',
			'default' => '',
			'prompt' => __('Default', 'church-event') ,
			'options' => array(
				'accent1' => __('Accent 1', 'church-event'),
				'accent2' => __('Accent 2', 'church-event'),
				'accent3' => __('Accent 3', 'church-event'),
				'accent4' => __('Accent 4', 'church-event'),
				'accent5' => __('Accent 5', 'church-event'),
				'accent6' => __('Accent 6', 'church-event'),
				'accent7' => __('Accent 7', 'church-event'),
				'accent8' => __('Accent 8', 'church-event'),
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Width (optional)', 'church-event') ,
			'desc' => __('Set to 0 is the full width.<br/><br/>', 'church-event') ,
			'id' => 'width',
			'default' => 0,
			'min' => 0,
			'max' => 960,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __('Height', 'church-event') ,
			'id' => 'height',
			'default' => '400',
			'min' => 0,
			'max' => 960,
			'step' => '1',
			'type' => 'range'
		) ,


		array(
			'name' => __('Title (optioanl)', 'church-event') ,
			'desc' => __('The title is placed just above the element.<br/><br/>', 'church-event'),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Title Type (optional)', 'church-event') ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __('Title with divider next to it', 'church-event'),
				'double' => __('Title with divider below', 'church-event'),
				'no-divider' => __('No Divider', 'church-event'),
			),
		) ,
	) ,
);