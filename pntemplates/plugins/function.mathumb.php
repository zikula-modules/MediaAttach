<?php
/**
 * MediaAttach
 *
 * @version      $Id$
 * @author       Axel Guckelsberger
 * @link         http://guite.de
 * @copyright    Copyright (C) 2008 by Guite
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

function smarty_function_mathumb($params, &$smarty)
{
    if (!isset($params['src'])) {
        $smarty->trigger_error('mathumb: parameter [src] required');
        return false;
    }

    // from pnimg

    // always provide an alt attribute.
    // if none is set, assign an empty one.
    $params['alt'] = isset($params['alt']) ? $params['alt'] : '';

    if (!isset($params['title'])) {
        $params['title'] = '';
    }

    // check if the alt string is an ml constant
    if (isset($params['altml']) && is_bool($params['altml']) && $params['altml']) {
        if ($params['title'] == $params['alt']) {
            $params['titleml'] = true;
        }
        $params['alt'] = constant($params['alt']);
    }
    // check if the title string is an ml constant
    if (isset($params['titleml']) && is_bool($params['titleml']) && $params['titleml'] && defined($params['title'])) {
        $params['title'] = constant($params['title']);
    }

    // prevent overwriting surrounding titles (#477)
    if (empty($params['title'])) {
        unset($params['title']);
    }

    $imgsrc = DataUtil::formatForOS($params['src']);

    // If neither width nor height is set, get these parameters.
    // If one of them is set, we do NOT obtain the real dimensions.
    // This way it is easy to scale the image to a certain dimension.
    if (!isset($params['width']) && !isset($params['height'])) {
        if (!$_image_data = @getimagesize($imgsrc)) {
            $smarty->trigger_error("mathumb: image $params[src] is not a valid image file");
            return false;
        }
        $params['width']  = $_image_data[0];
        $params['height'] = $_image_data[1];
    }

    unset($params['src']);
    unset($params['modname']);
    $assign = isset($params['assign']) ? $params['assign'] : null;
    unset($params['assign']);
    unset($params['altml']);
    unset($params['titleml']);

    $imgtag = '<img src="' . pnGetBaseURI() . '/' . $imgsrc . '" ';
    foreach ($params as $key => $value) {
        $imgtag .= $key . '="' . str_replace('"', '\'', $value) . '" ';
    }
    $imgtag .= '/>';

    if (!empty($assign)) {
        $params['src'] = $imgsrc;
        $params['imgtag'] = $imgtag;
        $smarty->assign($assign, $params);
    } else {
        return $imgtag;
    }
}
