$("ol.exemple").sortable({
	group: 'no-drop',
	handle: 'i.lni-arrows-vertical',
	pullPlaceholder: true,
	placeholderClass: 'placeholder',
	placeholder: '<li class="placeholder"></li>',
	onDragStart: function($item, container, _super) {
		// Duplicate items of the no drop area
		if (!container.options.drop)
			$item.clone().insertAfter($item);
		_super($item, container);
	},
	afterMove: function($placeholder, container, $closestItemOrContainer) {
	}
});
$("ol.exemple").sortable({
	group: 'no-drop',
	drop: false
});
$("ol.exemple").sortable({
	group: 'no-drop',
	drag: false
});