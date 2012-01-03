<?php
/**
 * @version		1.5.0
 * @package		AceSEF Library
 * @subpackage	Factory
 * @copyright	2009-2010 JoomAce LLC, www.joomace.net
 * @copyright   Yannick Gaultier - 2011
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No Permission
defined('_JEXEC') or die('Restricted Access');

// Factory class
class AcesefFactory {

  public static function &getConfig() {
     
    static $config;

    if (!is_object($config)) {
      $config = new stdClass();
       
      /***********************************************************************************************
       * ---------------------------------------------------------------------------------------------
       * CONFIGURATION INSTALLATION SECTION
       * ---------------------------------------------------------------------------------------------
       ***********************************************************************************************/
      $config = new stdClass();
      $config->mode = '1';
      $config->generate_sef = '1';
      $config->version_checker = '1';
      $config->purge_ext_urls = '1';
      $config->jquery_mode = '1';
      $config->download_id = '';
      $config->cache_instant = '1';
      $config->cache_versions = '1';
      $config->cache_extensions = '0';
      $config->cache_urls = '0';
      $config->cache_urls_size = '10000';
      $config->cache_metadata = '0';
      $config->cache_sitemap = '0';
      $config->cache_urls_moved = '0';
      $config->cache_tags = '0';
      $config->cache_ilinks = '1';
      $config->seo_h1 = '0';
      $config->seo_nofollow = '0';
      $config->page404 = 'custom';
      $config->url_lowercase = '1';
      $config->global_smart_itemid = '1';
      $config->numeral_duplicated = '0';
      $config->record_duplicated = '1';
      $config->url_suffix = '';
      $config->replacement_character = '-';
      $config->parent_menus = '0';
      $config->menu_url_part = 'title';
      $config->title_alias = 'title';
      $config->append_itemid = '0';
      $config->remove_trailing_slash = '1';
      $config->tolerant_to_trailing_slash = '1';
      $config->url_strip_chars = '^$%@#()+*!?.~:;|[]{},&¦';
      $config->source_tracker = '1';
      $config->insert_active_itemid = '0';
      $config->remove_sid = '0';
      $config->set_query_string = '1';
      $config->base_href = '3';
      $config->append_non_sef = '1';
      $config->prevent_dup_error = '1';
      $config->show_db_errors = '1';
      $config->check_url_by_id = '1';
      $config->non_sef_vars = 'format=feed, type=rss, type=atom';
      $config->disable_sef_vars = 'tmpl, no_html=1';
      $config->skip_menu_vars = '';
      $config->db_404_errors = '1';
      $config->log_404_errors = '0';
      $config->log_404_path = '/home/accountname/public_html/logs/acesef_404.log';
      $config->joomfish_main_lang = '0';
      $config->joomfish_main_lang_del = '0';
      $config->joomfish_lang_code = '1';
      $config->joomfish_trans_url = '1';
      $config->joomfish_cookie = '1';
      $config->joomfish_browser = '1';
      $config->utf8_url = '0';
      $config->char_replacements = 'Á|A, Â|A, Å|A, A|A, Ä|A, À|A, Ã|A, C|C, Ç|C, C|C, D|D, É|E, È|E, Ë|E, E|E, Ê|E, Ì|I, Í|I, Î|I, Ï|I, L|L, N|N, N|N, Ñ|N, Ò|O, Ó|O, Ô|O, Õ|O, Ö|O, O|O, R|R, R|R, Š|S, S|O, T|T, U|U, Ú|U, U|U, Ü|U, İ|Y, |Z, Z|Z, á|a, â|a, å|a, ä|a, à|a, ã|a, c|c, ç|c, c|c, d|d, d|d, é|e, e|e, ë|e, e|e, è|e, ê|e, ì|i, í|i, î|i, ï|i, l|l, n|n, n|n, ñ|n, ò|o, ó|o, ô|o, o|o, ö|o, õ|o, š|s, s|s, r|r, r|r, t|t, u|u, ú|u, u|u, ü|u, ı|y, |z, z|z, ?|-, ß|ss, A|A, µ|u, A|A, µ|u, a|a, A|A, e|e, E|E, s|s, S|S, z|z, Z|Z, z|z, Z|Z, c|c, C|C, l|l, L|L, ó|o, Ó|O, n|n, N|N, ?|B, ?|b, ?|V, ?|v, ?|G, ?|g, ?|D, ?|d, ?|Zh, ?|zh, ?|Z, ?|z, ?|I, ?|i, ?|Y, ?|y, ?|K, ?|k, ?|L, ?|l, ?|m, ?|N, ?|n, ?|P, ?|p, ?|t, ?|U, ?|u, ?|F, ?|f, ?|Ch, ?|ch, ?|Ts, ?|ts, ?|Ch, ?|ch, ?|Sh, ?|sh, ?|Sch, ?|sch, ?|I, ?|i, ?|E, ?|e, ?|U, ?|iu, ?|Ya, ?|ya, S|S, I|I, G|G, s|s, g|g, i|i, $|S, ¥|Y, £|L, ù|u, °|o, º|o, ª|a';
      $config->redirect_to_www = '0';
      $config->redirect_to_sef = '1';
      $config->redirect_to_sef_gen = '0';
      $config->jsef_to_acesef = '1';
      $config->force_ssl = '[]';
      $config->url_append_limit = '0';
      $config->meta_core = '1';
      $config->meta_title = '1';
      $config->meta_title_tag = '1';
      $config->meta_desc = '1';
      $config->meta_key = '1';
      $config->meta_generator = '';
      $config->meta_generator_rem = '1';
      $config->meta_abstract = '';
      $config->meta_revisit = '';
      $config->meta_direction = '';
      $config->meta_googlekey = '';
      $config->meta_livekey = '';
      $config->meta_yahookey = '';
      $config->meta_alexa = '';
      $config->meta_name_1 = '';
      $config->meta_name_2 = '';
      $config->meta_name_3 = '';
      $config->meta_con_1 = '';
      $config->meta_con_2 = '';
      $config->meta_con_3 = '';
      $config->meta_t_seperator = '-';
      $config->meta_t_sitename = '';
      $config->meta_t_usesitename = '1';
      $config->meta_t_prefix = '';
      $config->meta_t_suffix = '';
      $config->meta_key_blacklist = 'a, able, about, above, abroad, according, accordingly, across, actually, adj, after, afterwards, again, against, ago, ahead, ain\'t, all, allow, allows, almost, alone, along, alongside, already, also, although, always, am, amid, amidst, among, amongst, an, and, another, any, anybody, anyhow, anyone, anything, anyway, anyways, anywhere, apart, appear, appreciate, appropriate, are, aren\'t, around, as, a\'s, aside, ask, asking, associated, at, available, away, awfully, b, back, backward, backwards, be, became, because, become, becomes, becoming, been, before, beforehand, begin, behind, being, believe, below, beside, besides, best, better, between, beyond, both, brief, but, by, c, came, can, cannot, cant, can\'t, caption, cause, causes, certain, certainly, changes, clearly, c\'mon, co, co., com, come, comes, concerning, consequently, consider, considering, contain, containing, contains, corresponding, could, couldn\'t, course, c\'s, currently, d, dare, daren\'t, definitely, described, despite, did, didn\'t, different, directly, do, does, doesn\'t, doing, done, don\'t, down, downwards, during, e, each, edu, eg, eight, eighty, either, else, elsewhere, end, ending, enough, entirely, especially, et, etc, even, ever, evermore, every, everybody, everyone, everything, everywhere, ex, exactly, example, except, f, fairly, far, farther, few, fewer, fifth, first, five, followed, following, follows, for, forever, former, formerly, forth, forward, found, four, from, further, furthermore, g, get, gets, getting, given, gives, go, goes, going, gone, got, gotten, greetings, h, had, hadn\'t, half, happens, hardly, has, hasn\'t, have, haven\'t, having, he, he\'d, he\'ll, hello, help, , hence, her, here, hereafter, hereby, herein, here\'s, hereupon, hers, herself, he\'s, hi, him, himself, his, hither, hopefully, how, howbeit, however, hundred, i, i\'d, ie, if, ignored, i\'ll, i\'m, immediate, in, inasmuch, inc, inc., indeed, indicate, indicated, indicates, inner, inside, insofar, instead, into, inward, is, isn\'t, it, it\'d, it\'ll, its, it\'s, itself, i\'ve, j, just, k, keep, keeps, kept, know, known, knows, l, last, lately, later, latter, latterly, least, less, lest, let, let\'s, like, liked, likely, likewise, little, look, looking, looks, low, lower, ltd, m, made, mainly, make, makes, many, may, maybe, mayn\'t, me, mean, meantime, meanwhile, merely, might, mightn\'t, mine, minus, miss, more, moreover, most, mostly, mr, mrs, much, must, mustn\'t, my, myself, n, name, namely, nd, near, nearly, necessary, need, needn\'t, needs, neither, never, neverf, neverless, nevertheless, new, next, nine, ninety, no, nobody, non, none, nonetheless, noone, no-one, nor, normally, not, nothing, notwithstanding, novel, now, nowhere, o, obviously, of, off, often, oh, ok, okay, old, on, once, one, ones, one\'s, only, onto, opposite, or, other, others, otherwise, ought, oughtn\'t, our, ours, ourselves, out, outside, over, overall, own, p, particular, particularly, past, per, perhaps, placed, please, plus, possible, presumably, probably, provided, provides, q, que, quite, qv, r, rather, rd, re, really, reasonably, recent, recently, regarding, regardless, regards, relatively, respectively, right, round, s, said, same, saw, say, saying, says, second, secondly, , see, seeing, seem, seemed, seeming, seems, seen, self, selves, sensible, sent, serious, seriously, seven, several, shall, shan\'t, she, she\'d, she\'ll, she\'s, should, shouldn\'t, since, six, so, some, somebody, someday, somehow, someone, something, sometime, sometimes, somewhat, somewhere, soon, sorry, specified, specify, specifying, still, sub, such, sup, sure, t, take, taken, taking, tell, tends, th, than, thank, thanks, thanx, that, that\'ll, thats, that\'s, that\'ve, the, their, theirs, them, themselves, then, thence, there, thereafter, thereby, there\'d, therefore, therein, there\'ll, there\'re, theres, there\'s, thereupon, there\'ve, these, they, they\'d, they\'ll, they\'re, they\'ve, thing, things, think, third, thirty, this, thorough, thoroughly, those, though, three, through, throughout, thru, thus, till, to, together, too, took, toward, towards, tried, tries, truly, try, trying, t\'s, twice, two, u, un, under, underneath, undoing, unfortunately, unless, unlike, unlikely, until, unto, up, upon, upwards, us, use, used, useful, uses, using, usually, v, value, various, versus, very, via, viz, vs, w, want, wants, was, wasn\'t, way, we, we\'d, welcome, well, we\'ll, went, were, we\'re, weren\'t, we\'ve, what, whatever, what\'ll, what\'s, what\'ve, when, whence, whenever, where, whereafter, whereas, whereby, wherein, where\'s, whereupon, wherever, whether, which, whichever, while, whilst, whither, who, who\'d, whoever, whole, who\'ll, whom, whomever, who\'s, whose, why, will, willing, wish, with, within, without, wonder, won\'t, would, wouldn\'t, x, y, yes, yet, you, you\'d, you\'ll, your, you\'re, yours, yourself, yourselves, you\'ve, z, zero';
      $config->meta_key_whitelist = '';
      $config->sm_file = 'sitemap';
      $config->sm_xml_date = '1';
      $config->sm_xml_freq = '1';
      $config->sm_xml_prior = '1';
      $config->sm_ping_type = 'link';
      $config->sm_ping = '1';
      $config->sm_yahoo_appid = '';
      $config->sm_ping_services = 'http://blogsearch.google.com/ping/RPC2, http://rpc.pingomatic.com/';
      $config->sm_freq = 'weekly';
      $config->sm_priority = '0.5';
      $config->sm_auto_mode = '1';
      $config->sm_auto_components = '[\"com_content\"]';
      $config->sm_auto_enable_cats = '0';
      $config->sm_auto_filter_s = '.pdf';
      $config->sm_auto_filter_r = 'format=pdf, format=feed, type=rss';
      $config->sm_auto_cron_mode = '0';
      $config->sm_auto_cron_freq = '24';
      $config->sm_auto_cron_last = '1286615325';
      $config->sm_auto_xml = '1';
      $config->sm_auto_ping_c = '0';
      $config->sm_auto_ping_s = '0';
      $config->tags_mode = '1';
      $config->tags_area = '1';
      $config->tags_components = '[\"com_content\"]';
      $config->tags_enable_cats = '0';
      $config->tags_in_cats = '0';
      $config->tags_in_page = '15';
      $config->tags_order = 'ordering';
      $config->tags_position = '2';
      $config->tags_limit = '20';
      $config->tags_show_tag_desc = '0';
      $config->tags_show_prefix = '1';
      $config->tags_show_item_desc = '1';
      $config->tags_exp_item_desc = '0';
      $config->tags_published = '1';
      $config->tags_auto_mode = '0';
      $config->tags_auto_components = '[\"com_content\"]';
      $config->tags_auto_length = '4';
      $config->tags_auto_filter_s = '.pdf';
      $config->tags_auto_filter_r = 'format=pdf, format=feed, type=rss';
      $config->tags_auto_blacklist = 'a, able, about, above, abroad, according, accordingly, across, actually, adj, after, afterwards, again, against, ago, ahead, ain\'t, all, allow, allows, almost, alone, along, alongside, already, also, although, always, am, amid, amidst, among, amongst, an, and, another, any, anybody, anyhow, anyone, anything, anyway, anyways, anywhere, apart, appear, appreciate, appropriate, are, aren\'t, around, as, a\'s, aside, ask, asking, associated, at, available, away, awfully, b, back, backward, backwards, be, became, because, become, becomes, becoming, been, before, beforehand, begin, behind, being, believe, below, beside, besides, best, better, between, beyond, both, brief, but, by, c, came, can, cannot, cant, can\'t, caption, cause, causes, certain, certainly, changes, clearly, c\'mon, co, co., com, come, comes, concerning, consequently, consider, considering, contain, containing, contains, corresponding, could, couldn\'t, course, c\'s, currently, d, dare, daren\'t, definitely, described, despite, did, didn\'t, different, directly, do, does, doesn\'t, doing, done, don\'t, down, downwards, during, e, each, edu, eg, eight, eighty, either, else, elsewhere, end, ending, enough, entirely, especially, et, etc, even, ever, evermore, every, everybody, everyone, everything, everywhere, ex, exactly, example, except, f, fairly, far, farther, few, fewer, fifth, first, five, followed, following, follows, for, forever, former, formerly, forth, forward, found, four, from, further, furthermore, g, get, gets, getting, given, gives, go, goes, going, gone, got, gotten, greetings, h, had, hadn\'t, half, happens, hardly, has, hasn\'t, have, haven\'t, having, he, he\'d, he\'ll, hello, help, , hence, her, here, hereafter, hereby, herein, here\'s, hereupon, hers, herself, he\'s, hi, him, himself, his, hither, hopefully, how, howbeit, however, hundred, i, i\'d, ie, if, ignored, i\'ll, i\'m, immediate, in, inasmuch, inc, inc., indeed, indicate, indicated, indicates, inner, inside, insofar, instead, into, inward, is, isn\'t, it, it\'d, it\'ll, its, it\'s, itself, i\'ve, j, just, k, keep, keeps, kept, know, known, knows, l, last, lately, later, latter, latterly, least, less, lest, let, let\'s, like, liked, likely, likewise, little, look, looking, looks, low, lower, ltd, m, made, mainly, make, makes, many, may, maybe, mayn\'t, me, mean, meantime, meanwhile, merely, might, mightn\'t, mine, minus, miss, more, moreover, most, mostly, mr, mrs, much, must, mustn\'t, my, myself, n, name, namely, nd, near, nearly, necessary, need, needn\'t, needs, neither, never, neverf, neverless, nevertheless, new, next, nine, ninety, no, nobody, non, none, nonetheless, noone, no-one, nor, normally, not, nothing, notwithstanding, novel, now, nowhere, o, obviously, of, off, often, oh, ok, okay, old, on, once, one, ones, one\'s, only, onto, opposite, or, other, others, otherwise, ought, oughtn\'t, our, ours, ourselves, out, outside, over, overall, own, p, particular, particularly, past, per, perhaps, placed, please, plus, possible, presumably, probably, provided, provides, q, que, quite, qv, r, rather, rd, re, really, reasonably, recent, recently, regarding, regardless, regards, relatively, respectively, right, round, s, said, same, saw, say, saying, says, second, secondly, , see, seeing, seem, seemed, seeming, seems, seen, self, selves, sensible, sent, serious, seriously, seven, several, shall, shan\'t, she, she\'d, she\'ll, she\'s, should, shouldn\'t, since, six, so, some, somebody, someday, somehow, someone, something, sometime, sometimes, somewhat, somewhere, soon, sorry, specified, specify, specifying, still, sub, such, sup, sure, t, take, taken, taking, tell, tends, th, than, thank, thanks, thanx, that, that\'ll, thats, that\'s, that\'ve, the, their, theirs, them, themselves, then, thence, there, thereafter, thereby, there\'d, therefore, therein, there\'ll, there\'re, theres, there\'s, thereupon, there\'ve, these, they, they\'d, they\'ll, they\'re, they\'ve, thing, things, think, third, thirty, this, thorough, thoroughly, those, though, three, through, throughout, thru, thus, till, to, together, too, took, toward, towards, tried, tries, truly, try, trying, t\'s, twice, two, u, un, under, underneath, undoing, unfortunately, unless, unlike, unlikely, until, unto, up, upon, upwards, us, use, used, useful, uses, using, usually, v, value, various, versus, very, via, viz, vs, w, want, wants, was, wasn\'t, way, we, we\'d, welcome, well, we\'ll, went, were, we\'re, weren\'t, we\'ve, what, whatever, what\'ll, what\'s, what\'ve, when, whence, whenever, where, whereafter, whereas, whereby, wherein, where\'s, whereupon, wherever, whether, which, whichever, while, whilst, whither, who, who\'d, whoever, whole, who\'ll, whom, whomever, who\'s, whose, why, will, willing, wish, with, within, without, wonder, won\'t, would, wouldn\'t, x, y, yes, yet, you, you\'d, you\'ll, your, you\'re, yours, yourself, yourselves, you\'ve, z, zero';
      $config->ilinks_mode = '1';
      $config->ilinks_area = '1';
      $config->ilinks_components = '[\"com_content\"]';
      $config->ilinks_enable_cats = '0';
      $config->ilinks_in_cats = '0';
      $config->ilinks_case = '1';
      $config->ilinks_published = '1';
      $config->ilinks_nofollow = '0';
      $config->ilinks_blank = '0';
      $config->ilinks_limit = '10';
      $config->bookmarks_mode = '1';
      $config->bookmarks_area = '1';
      $config->bookmarks_components = '[\"com_content\"]';
      $config->bookmarks_enable_cats = '0';
      $config->bookmarks_in_cats = '0';
      $config->bookmarks_twitter = '';
      $config->bookmarks_addthis = '';
      $config->bookmarks_taf = '';
      $config->bookmarks_icons_pos = '2';
      $config->bookmarks_icons_txt = 'Share:';
      $config->bookmarks_icons_line = '35';
      $config->bookmarks_published = '1';
      $config->bookmarks_type = 'icon';
      $config->ui_cpanel = '2';
      $config->ui_sef_language = '0';
      $config->ui_sef_published = '1';
      $config->ui_sef_used = '1';
      $config->ui_sef_locked = '1';
      $config->ui_sef_blocked = '0';
      $config->ui_sef_cached = '1';
      $config->ui_sef_date = '0';
      $config->ui_sef_hits = '1';
      $config->ui_sef_id = '0';
      $config->ui_moved_published = '1';
      $config->ui_moved_hits = '1';
      $config->ui_moved_clicked = '1';
      $config->ui_moved_cached = '1';
      $config->ui_moved_id = '1';
      $config->ui_metadata_keys = '1';
      $config->ui_metadata_published = '1';
      $config->ui_metadata_cached = '1';
      $config->ui_metadata_id = '0';
      $config->ui_sitemap_title = '1';
      $config->ui_sitemap_published = '1';
      $config->ui_sitemap_id = '1';
      $config->ui_sitemap_parent = '1';
      $config->ui_sitemap_order = '1';
      $config->ui_sitemap_date = '1';
      $config->ui_sitemap_frequency = '1';
      $config->ui_sitemap_priority = '1';
      $config->ui_sitemap_cached = '1';
      $config->ui_tags_published = '1';
      $config->ui_tags_ordering = '1';
      $config->ui_tags_cached = '1';
      $config->ui_tags_hits = '1';
      $config->ui_tags_id = '0';
      $config->ui_ilinks_published = '1';
      $config->ui_ilinks_nofollow = '1';
      $config->ui_ilinks_blank = '1';
      $config->ui_ilinks_limit = '1';
      $config->ui_ilinks_cached = '1';
      $config->ui_ilinks_id = '1';
      $config->ui_bookmarks_published = '1';
      $config->ui_bookmarks_id = '1';
    }

    return $config;
  }

  function &getCache($lifetime = '315360000') {

    return null;
  }

  function getTable($name) {

    return null;
  }
}
