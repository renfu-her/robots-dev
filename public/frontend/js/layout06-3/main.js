$(document).ready(function() {
	//手機板選單功能，數字為手機板選單要出現的寬度
	mobileMenuInit(1000);
	//上方主選單.menu的功能
	menuInit();
	//啟動選單上購物車下拉列表
	gocartBtnInit();
	//按鈕切換class功能
	toggleBtnInit();
	//側選單開合
	sideNavInit();
	//語系下拉，沒有下拉請註解這行
	languageMenuInit('.site-header .language');
	//表單單選&多選按鈕選定時，在外層label加上 ckecked 的class
	labelCkeckedInit();
	//TOP按鈕的功能
	gotopBtnInit();
	masonry('.masonry-list');
});
$(window).on('scroll', function() {
	//捲動超過header時，body會加上 header-fixed
	if ($(this).scrollTop() > $('.site-header').height()){
		$('body').addClass('header-fixed');
	} else {
		$('body').removeClass('header-fixed');
	}
}).scroll();
