<?php
/**
 * DokuWiki Plugin slidesharewp (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Hanson  Kim <sng2nara@gmail.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_slidesharewp_slidesharewp extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 159;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\[slideshare .+?\]',$mode,'plugin_slidesharewp_slidesharewp');
    }

//    public function postConnect() {
//        $this->Lexer->addExitPattern('</FIXME>','plugin_slidesharewp_slidesharewp');
//    }

    /**
     * Handle matches of the slidesharewp syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler &$handler){
        $pm = preg_match_all('/\[slideshare id=(.+?)&doc=(.+?)\]/', $match, $result);
        $id = $result[1][0];
        $doc = $result[2][0];
        return array($id, $doc);
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer &$renderer, $data) {
        if($mode != 'xhtml') return false;
        list($id, $doc) = $data;
        $id = urlencode($id);
        $renderer->doc .= "<iframe src=\"http://www.slideshare.net/slideshow/embed_code/$id\" 
        width=\"425\" height=\"355\" frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" 
        style=\"border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%%;\" allowfullscreen></iframe>";
        $renderer->doc .= NL;
        return true;
    }
}

// vim:ts=4:sw=4:et:
