<?php
class validateKakaoMap extends validate {

    public function __construct($paramNameType = Constants::KAKAOMAP_SAVE,
                                $paramNameItem = Constants::KAKAOMAP_STYLE,
                                $paramNameItemDisplay = Constants::KAKAOMAP_POSITION)
    {
        parent::__construct($paramNameType, $paramNameItem, $paramNameItemDisplay);
    }

    public function isPostValidate(){
        if(!parent::isSaveTrue()) return false;
        if(!parent::validateString(Constants::KAKAOMAP_STYLE)) return false;
        if(!parent::validateString(Constants::KAKAOMAP_POSITION)) return false;
        return true;
    }
    public function getOptionKakaoMapStyle(){
        return esc_html(get_option(Constants::KAKAOMAP_STYLE));
    }
    public function getOptionKakaoMapPosition(){
        return str_replace(array("\'"), "'" ,html_entity_decode(get_option(Constants::KAKAOMAP_POSITION), ENT_QUOTES));
    }
    public function updatePostKakaoMapOption(){
        if($this->isPostValidate()){
            update_option(Constants::KAKAOMAP_STYLE, $this->postDataItem);
            update_option(Constants::KAKAOMAP_POSITION, $this->postDataItemDisplay);
            $this->saveCompleteMsg(Constants::KAKAOMAP_TITLE);
        }
    }
    public function getShortCode($content){
        if (!is_admin()) {
            return $this->kakaomap();
        }
        return $content;
    }
    function kakaomap()
    {
        $style = $this->getOptionKakaoMapStyle();
        $position = $this->getOptionKakaoMapPosition();
        return '
	<div id="map_tam_wordpress_plugin" style="'.$style.'"></div>
	<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey='.esc_html(get_option(Constants::JAVASCRIPT_KEY)).'"></script>
	<script>
		var container = document.getElementById("map_tam_wordpress_plugin");
		var options = {
			center: new kakao.maps.LatLng('.$position.'),
			level: 3
			
		};

		var map = new kakao.maps.Map(container, options);
	</script>         
    ';
    }

}

