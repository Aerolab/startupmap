<div id="modalCountrySelect">
	<div class="modal">
		<h3>Elige un país</h3>
		{{ Form::select('modalCountrySelector', array_merge(array( '' => 'Selecciona Pais' ), Country::where('enabled', 'y')->get()->lists('name', 'iso')), '', array( 'id' => 'modalCountrySelector' )) }}
	</div>
</div>
