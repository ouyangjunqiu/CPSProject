<?php
/**
 * TOP API: taobao.poster.postauctions.get request
 *
 * @author auto create
 * @since 1.0, 2011-09-29 15:36:21
 */
class TopLinker_Request_PosterPostauctionsGet extends TopLinker_Request_Abstract
{
    /**
     * 画报ID
     **/
    public $posterId;

    public function rules()
    {
        return array();
        //RequestCheckUtil::checkNotNull($this->posterId, "posterId");
        //RequestCheckUtil::checkMaxValue($this->posterId, 2147483646, "posterId");
        //RequestCheckUtil::checkMinValue($this->posterId, 1, "posterId");
    }
}
