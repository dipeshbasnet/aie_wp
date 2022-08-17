document.querySelector('body').addEventListener("change", function (e) {
	var el = document.querySelector('.block-editor-inserter__tabs .block-editor-inserter__panel-header .components-select-control__input');
	if(el && el.value.trim().toLowerCase() === 'essential-blocks'){
		var btn = document.createElement('a');
		btn.classList.add('eb-more-patterns-btn');
		btn.href = '#';
		if(EssentialBlocksLocalize.is_templately_active){
			btn.innerHTML = 'See more in <strong>Templately</strong>';
			btn.classList.add('templately-active');
		}
		if(!EssentialBlocksLocalize.is_templately_active && EssentialBlocksLocalize.is_templately_installed){
			btn.innerHTML = 'Active <strong>Templately</strong> to get more';
			btn.href = EssentialBlocksLocalize.eb_admin_url + 'plugins.php';
			btn.target = "_blank";
		}
		if(!EssentialBlocksLocalize.is_templately_active && !EssentialBlocksLocalize.is_templately_installed){
			btn.innerHTML = 'Install <strong>Templately</strong> to get more';
			btn.href = EssentialBlocksLocalize.eb_admin_url + 'plugin-install.php?s=templately&tab=search&type=term';
			btn.target = "_blank";
		}
		el.closest('.components-tab-panel__tab-content').append(btn);
	}else{
		btn = document.querySelector('.eb-more-patterns-btn');
		if(btn){
			btn.remove();
		}
	}
	var templatelyBtn = document.querySelector('.eb-more-patterns-btn.templately-active');
	if(templatelyBtn){
		templatelyBtn.addEventListener('click', function (e) {
			document.querySelector('.gutenberg-add-templately-button').click();
			// document.querySelector('#templately-gutenberg-button').click();
		});
	}
});

/*var observer = new MutationObserver(function (mutationsList) {
	var el = document.querySelector('.block-editor-block-patterns-explorer');
	if(el){

	}
});

observer.observe(document.querySelector('body'), {childList: true});*/


