<?php
/**
 *	constants.php
 *	Holds all of our constants
 *
 *	Written by Tyler Wright
 * 	Last Modified: 3.5.2008
 */

/**
 *	Database Constants
 * 	This is the default database for
 *	the site
 */
define("DB_USER", "admin");
define("DB_PASS", "B!urr999");
define("DB_SERVER", "192.168.226.1");
define("DB_NAME", "podunkton");

/**
 *	Cookie Constants
 *	Basic cookie variables
 */
define("COOKIE_EXPIRE", 60*60*24*100);
define("COOKIE_PATH", "/");

/**
 *	Special Constants
 *	Site affecting variables
 */
define("BETA", 0);

/**
 *	Site Constants
 *	Variables set for the entire site
 */
define("RESULTS_PER_PAGE", 10);
define("RESULTS_PER_SUBCATEGORY", 10);
define("RESULTS_PER_SUBCATEGORY_LIST", 20);
define("ITEMS_PER_STORE_PAGE", 10);
define("COMMENTS_PER_PAGE", 8);
define("ADVANCED_RESULTS_PER_PAGE", 20);

/**
 * Economy System
 */
define("SECONDS_PER_POST", 10);
define("SECONDS_PER_PAGE", 20);
define("MUNNIEZ_PER_PAGE_MAX", 3);
define("MUNNIEZ_PER_POST", 4);
define("MUNNIEZ_PER_TOPIC", 4);
define("MUNNIEZ_PER_THUMB", 1);
define("MUNNIEZ_ON_SIGNUP", 500);
define("TRADING_PASS_COST", 1000);
define("MUNNIEZ_PER_POLL", 5);

/**
 * Experience System
 * Variables for use in experience
 */
define("EXP_PER_POST", 10);
define("EXP_PER_TOPIC", 15);
define("EXP_PER_THUMB", 5);
define("EXP_MODIFIER", 1.23);
define("EXP_BASE_VAR", 100);

/**
 * Audio Variables
 * Variables for use in the audio section
 */
define("GOLD_RECORD", 100);
define("PLATINUM_RECORD", 200);

/**
 * Admin Variables
 * Variables for use in the admin section
 */
define("ADMIN_ITEMS_PER_PAGE", 10);
define("ADMIN_BADGES_PER_PAGE",20);

/**
 * Paypal Variables
 * Variables for use in the link with paypal
 * note: These need to be moved into the database for management
 */
define("RETURN_URL", "http://www.podunkton.com/thanks");
define("CANCEL_URL", "http://www.podunkton.com/cancel");
define("CREDITS_50_NAME", "50 Credits");
define("CREDITS_100_NAME", "100 Credits");
define("CREDITS_200_NAME", "200 Credits");
define("CREDITS_50_ITEMID", "CR50");
define("CREDITS_100_ITEMID", "CR100");
define("CREDITS_200_ITEMID", "CR200");
define("CREDITS_50_PRICE", "5.00");
define("CREDITS_100_PRICE", "9.00");
define("CREDITS_200_PRICE", "15.00");
define("MONTHLY_NAME", "Hallow Bag");
define("MONTHLY_ITEMID", "187");
define("MONTHLY_PRICE", "3.00");

?>