<?php
/* CONSTANTEN */

define('LOGIN_MASKE', "/^[a-zA-Z0-9]$/");



	/* PERM_RECHTE fg_wf 10 */
	/**
	 * Komplette zugrirffsrechte
	 *
	 * @var 10000
	 */
define('PERM_OWNER',100000);

	/* PERM_RECHTE fg_wf 10 */
	/**
	 * Komplette zugrirffsrechte
	 *
	 * @var 10000
	 */
define('PERM_ADMIN',10000);

	/**
	 * Partner administrator hat komplete zugriff auf gruppen und user verwaltung, dokumenten und statistik
	 *
	 * @var 1000
	 */
define('PERM_PARTNER_ADMIN',1000);

	/**
	 * Group administrator hat komplete zugriff auf user verwaltung , dokumenten und statistik
	 *
	 * @var 900
	 */
define('PERM_GROUP_ADMIN',900);

	/**
	 * PERM_OPERATOR hat zugriff auf zugewiesene dokumenten
	 *
	 * @var 800
	 */
define('PERM_OPERATOR',800);

	/**
	 * PERM_MONITOR hat leserechte auf zugewiesene dokumenten
	 *
	 * @var 700
	 */
define('PERM_MONITOR',700);


	/**
	 * PERM_EMPTY nicht eingelogte benuzter
	 *
	 * @var 0
	 */
define('PERM_EMPTY',0);


	/**
	 * castom maske z.b. /^arkt/
	 *
	 * @var int = 0
	 */
define('MSK_CUSTOM',0);

	/**
	 * Email adresse my@email.de
	 *
	 * @var int = 1
	 */
define('MSK_EMAIL',1);

	/**
	 * Date format (01.01.1970)
	 *
	 * @var int = 3
	 */
define('MSK_DATE',3);

	/**
	 * Zahl format (1234345...)
	 *
	 * @var int = 4
	 */
define('MSK_ZAHL',4);

	/**
	 * Integer format base(10)
	 *
	 * @var int = 5
	 */
define('MSK_INT',5);

	/**
	 * Float format (23.34)
	 *
	 * @var int = 6
	 */
define('MSK_FLOAT',6);

	/**
	 * Login format
	 *
	 * @var int = 7
	 */
define('MSK_LOGIN',7);

	/**
	 * Password format
	 *
	 * @var int = 8
	 */
define('MSK_PASSWORD',8);

	/**
	 * String format ([a..z A..Z 0..9 - _ .])
	 *
	 * @var int = 9
	 */
define('MSK_SAFESTRING',9);

class FgVars{

	/* style objects */
	const CSS_LINK = 'css_link';
	const CSS_INLINE = 'css_inline';
	const JS_LINK = 'js_link';
	const JS_INLINE = 'js_inline';
	const JS_ONLOAD = 'js_onload';
	const METATAG = 'metatag';
	
	
	/* mysoft status */
	const FG_MYSOFT_STATUS_INSTALL = 0;
	const FG_MYSOFT_STATUS_ACTIVE = 1;
	const FG_MYSOFT_STATUS_DELETED = 2;
	

	/*  OBJECTS TYPES */
	const FG_TYPE_PERMISSIONS = 1000;
	const FG_TYPE_LINKS = 1001;
	const FG_TYPE_FAVORITE = 1002;

	const FG_TYPE_PARTNER = 10000; // fg_partner table
	const FG_TYPE_GROUP = 11000; // fg_group table
	const FG_TYPE_USER = 12000; // fg_user table

	const FG_TYPE_CRYPTODIRA_USER=12100; // fg_cryptodira
	const FG_TYPE_CRYPTODIRA_DEVICE=12200; // fg_device

	const FG_TYPE_CRYPTODIRA_SOFT=12300;
	const FG_TYPE_CRYPTODIRA_SOFT_LANG=12301;

	const FG_TYPE_CRYPTODIRA_LINE=12310;
	const FG_TYPE_CRYPTODIRA_LINE_LANG=12311;

	const FG_TYPE_CRYPTODIRA_VERSION=12320;
	const FG_TYPE_CRYPTODIRA_PIN=12400;
	const FG_TYPE_CRYPTODIRA_MYSOFT=12500; //fg_crypto_mysoft
	const FG_TYPE_CRYPTODIRA_HISTORY=12550; //fg_crypto_history
	
	const FG_TYPE_CRYPTODIRA_GALERY=12610;
	const FG_TYPE_CRYPTODIRA_GALERY_LANG=12611;
	
	const FG_TYPE_CRYPTODIRA_COMMENT=12710;
	

	const FG_TYPE_KONTAKT = 13000; // fg_kontakt
	const FG_TYPE_PERSON = 14000;  // fg_person
	const FG_TYPE_MENU_GROUP = 15000; // fg_menu_group
	const FG_TYPE_MENU_ITEM = 15500;  // fg_menu

	const FG_TYPE_ITEMS=16000;
	const FG_TYPE_ITEMS_LANG=16001;

	const FG_TYPE_WF=17000;
	const FG_TYPE_WF_LANG=17001;
	/*END  OBJECTS TYPES */



	const WV_GROUP_LANGUAGES = 24;
	const WV_GROUP_MODULE = 20;
	const WV_GROUP_PERMISSIONS = 10;
	const WV_GROUP_KATEGORY = 28;
	const WV_GROUP_PAYTYPE = 31;
	const WV_GROUP_MAIN_TEMPLATES = 35;


	private static $arTabName = array(
		self::FG_TYPE_PARTNER=>'fg_partner',
		self::FG_TYPE_GROUP=>'fg_group',
		self::FG_TYPE_USER=>'fg_user',
		self::FG_TYPE_KONTAKT=>'fg_kontakt',
		self::FG_TYPE_PERSON=>'fg_person',

		self::FG_TYPE_MENU_GROUP=>'fg_menu_group',
		self::FG_TYPE_MENU_ITEM=>'fg_menu',

		self::FG_TYPE_CRYPTODIRA_USER=>'fg_crypto_user',
		self::FG_TYPE_CRYPTODIRA_DEVICE=>'fg_device',
		self::FG_TYPE_CRYPTODIRA_PIN=>'fg_crypto_pin',

		self::FG_TYPE_CRYPTODIRA_SOFT=>'fg_crypto_catalog',
		self::FG_TYPE_CRYPTODIRA_SOFT_LANG=>'fg_crypto_catalog_lang',

		self::FG_TYPE_CRYPTODIRA_LINE=>'fg_crypto_line',
		self::FG_TYPE_CRYPTODIRA_LINE_LANG=>'fg_crypto_line_lang',

		self::FG_TYPE_CRYPTODIRA_GALERY=>'fg_crypto_galery',
		self::FG_TYPE_CRYPTODIRA_GALERY_LANG=>'fg_crypto_galery_lang',
		
		self::FG_TYPE_CRYPTODIRA_COMMENT=>'fg_crypto_comments',		
		
		self::FG_TYPE_CRYPTODIRA_VERSION=>'fg_crypto_version',
		self::FG_TYPE_CRYPTODIRA_MYSOFT=>'fg_crypto_mysoft',
		self::FG_TYPE_CRYPTODIRA_HISTORY=>'fg_crypto_history',

		self::FG_TYPE_ITEMS=>'fg_items',
		self::FG_TYPE_ITEMS_LANG=>'fg_items_lang',

		self::FG_TYPE_WF=>'fg_wf',
		self::FG_TYPE_WF_LANG=>'fg_wf_lang',

		self::FG_TYPE_PERMISSIONS=>'fg_perm',
		self::FG_TYPE_LINKS=>'fg_links',
		self::FG_TYPE_FAVORITE=>'fg_favorite'		
	);



	public static function getTablePerType($type)
	{
		if(array_key_exists($type, self::$arTabName))
		{
			return self::$arTabName[$type];
		}
		else
		{
			return '';
		}
	}


}
