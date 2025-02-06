(function($){
	$.fn.validationEngineLanguage = function(){
	};
	$.validationEngineLanguage = {
		newLang: function(){
			$.validationEngineLanguage.allRules = {
				"required": {
					// Add your regex rules here, you can take telephone as an example
					"regex": "none",
					"alertText": "* 此欄位不可空白",
					"alertTextCheckboxMultiple": "* 請選擇一個項目",
					"alertTextCheckboxe": "* 您必需勾選此欄位",
					"alertTextDateRange": "* 日期範圍欄位都不可空白"
				},
				"rocid": {
					"func": function(field, rules, i, options){
						tab = "ABCDEFGHJKLMNPQRSTUVXYWZIO";
						A1 = new Array (1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3 );
						A2 = new Array (0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5 );
						Mx = new Array (9,8,7,6,5,4,3,2,1,1);

						if ( field.val().length != 10 ) return false;
						i = tab.indexOf( field.val().charAt(0) );
						if ( i == -1 ) return false;
						sum = A1[i] + A2[i]*9;

						for ( i=1; i<10; i++ ) {
							v = parseInt( field.val().charAt(i) );
							if ( isNaN(v) ) return false;
							sum = sum + v * Mx[i];
						}
						if ( sum % 10 != 0 ) return false;
						return true;
					},
					"alertText": "* 無效的身份證字號"
				},
				"requiredInFunction": {
					"func": function(field, rules, i, options){
						return (field.val() == "test") ? true : false;
					},
					"alertText": "* Field must equal test"
				},
				"dateRange": {
					"regex": "none",
					"alertText": "* 無效的 ",
					"alertText2": " 日期範圍"
				},
				"dateTimeRange": {
					"regex": "none",
					"alertText": "* 無效的 ",
					"alertText2": " 時間範圍"
				},
				"minSize": {
					"regex": "none",
					"alertText": "* 最少 ",
					"alertText2": " 個字元"
				},
				"maxSize": {
					"regex": "none",
					"alertText": "* 最多 ",
					"alertText2": " 個字元"
				},
				"groupRequired": {
					"regex": "none",
					"alertText": "* 你必需選填其中一個欄位"
				},
				"min": {
					"regex": "none",
					"alertText": "* 最小值為 "
				},
				"max": {
					"regex": "none",
					"alertText": "* 最大值為 "
				},
				"past": {
					"regex": "none",
					"alertText": "* 日期必需早於 "
				},
				"future": {
					"regex": "none",
					"alertText": "* 日期必需晚於 "
				},
				"maxCheckbox": {
					"regex": "none",
					"alertText": "* 最多選取 ",
					"alertText2": " 個項目"
				},
				"minCheckbox": {
					"regex": "none",
					"alertText": "* 請選取 ",
					"alertText2": " 個項目"
				},
				"equals": {
					"regex": "none",
					"alertText": "* 密碼與確認密碼欄位內容不相符"
				},
				"creditCard": {
					"regex": "none",
					"alertText": "* 无效的信用卡号码"
				},
				"phone": {
					// credit: jquery.h5validate.js / orefalo
					"regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
					"alertText": "* 無效的電話號碼"
				},
				"mobile": {
					"regex": /^09\d{8}$/,
					"alertText": "* 無效的手機號碼"
				},
				"email": {
					// Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
					"regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
					"alertText": "* E-mail格式錯誤"
				},
				"integer": {
					"regex": /^[\-\+]?\d+$/,
					"alertText": "* 不是有效的整數"
				},
				"number": {
					// Number, including positive, negative, and floating decimal. credit: orefalo
					"regex": /^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,
					"alertText": "* 無效的數字"
				},
				"date": {
					"regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/,
					"alertText": "* 無效的日期，格式必需為 YYYY-MM-DD"
				},
				"ipv4": {
					"regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
					"alertText": "* 無效的 IP 位址"
				},
				"url": {
					"regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
					"alertText": "* Invalid URL"
				},
				"onlyNumberSp": {
					"regex": /^[0-9\ ]+$/,
					"alertText": "* 只能填數字"
				},
				"onlyLetterSp": {
					"regex": /^[a-zA-Z\ \']+$/,
					"alertText": "* 只接受英文字母大小寫"
				},
				"onlyLetterNumber": {
					"regex": /^[0-9a-zA-Z]+$/,
					"alertText": "* 不接受特殊字元"
				},
				// --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
				"ajaxUserCall": {
					"url": "ajaxValidateFieldUser",
					// you may want to pass extra data on the ajax call
					"extraData": "name=eric",
					"alertText": "* 此名稱已經被其他人使用",
					"alertTextLoad": "* 正在確認名稱是否有其他人使用，請稍等。"
				},
				"ajaxUserData": {
					"url": "ajax/checkuserdata",
					"extraData": "name=eric",
					"alertText": "* 資料格式錯誤！",
					"alertTextLoad": "* 正在確認資料，請稍等。"
				},
				"ajaxUserCallPhp": {
					"url": "ajax/checkaccount",
					"alertTextOk": "* 此帳號名稱可以使用",
					"alertText": "* 此帳號名稱已經被其他人使用",
					"alertTextLoad": "* 正在確認帳號名稱是否有其他人使用，請稍等。"
				},
				"ajaxPasswordPhp": {
					"url": "ajax/checkpassword",
					"alertTextOk": "* 此密碼可以使用",
					"alertText": "* 密碼格式錯誤，請混合使用8個字元(含)以上的英文字母和數字",
					"alertTextLoad": "* 正在確認密碼格式，請稍等。"
				},
				"ajaxNameCall": {
					// remote json service location
					"url": "ajaxValidateFieldName",
					// error
					"alertText": "* 此名稱可以使用",
					// if you provide an "alertTextOk", it will show as a green prompt when the field validates
					"alertTextOk": "* 此名稱已經被其他人使用",
					// speaks by itself
					"alertTextLoad": "* 正在確認名稱是否有其他人使用，請稍等。"
				},
				"ajaxOrderNumberCallPhp": {
					// remote json service location
					"url": "ajax/payfrom",
					// error
					"alertText": "* 查無此訂單編號,請您確認,謝謝您。",
					// speaks by itself
					"alertTextLoad": "* 確認有無訂單中。"
				},
				"ajaxMemberPhoneCallPhp": {
					// remote json service location
					"url": "ajax/memberphone",
					// error
					"alertText": "* 無效的電話號碼,請您確認,謝謝您。",
					// speaks by itself
					"alertTextLoad": "* 確認格式中。"
				},
				"validate2fields": {
					"alertText": "* 請輸入 HELLO"
				},
				//tls warning:homegrown not fielded
				"dateFormat":{
					"regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/,
					"alertText": "* 無效的日期格式"
				},
				//tls warning:homegrown not fielded
				"dateTimeFormat": {
					"regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/,
					"alertText": "* 無效的日期或時間格式",
					"alertText2": "可接受的格式： ",
					"alertText3": "mm/dd/yyyy hh:mm:ss AM|PM 或 ",
					"alertText4": "yyyy-mm-dd hh:mm:ss AM|PM"
				}
			};
		}
	};
	$.validationEngineLanguage.newLang();
})(jQuery);