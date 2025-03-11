function shareMessage(url) {
  Kakao.Share.sendScrap({
    requestUrl: url,
  });
}

function kakaotalkMeMessage() {
  window.scrollTo(0, 0);
  document.getElementById('kakaotalkMeLayerBg').style.display = 'block';
  document.getElementById('kakaotalkMeLayer').style.display = 'block';
}
function kakaotalkMeLayerClose() {
  document.getElementById('kakaotalkMeLayerBg').style.display = 'none';
  document.getElementById('kakaotalkMeLayer').style.display = 'none';
}
function kakaotalkMeSend(url) {
  const text = document.getElementById('kakaotalk-me-txt').value.replace(/\n/g, ' ');
  if(text.trim() == '') {
    alert('200자 이내로 입력해주세요.');
    return;
  }
  if(text.length > 200) {
    alert('200자 이내로 입력해주세요.');
    return;
  }
  jQuery(document).ready(function($) {
    var data = {
      'action': 'kakao_api',
      'type': 'kakaotalkMe',
      'url': url,
      'text': text,
      'state': ajax_object.state
    };
    jQuery.post(ajax_object.ajax_url, data, function(response) {
      kakaotalkMeLayerClose();
      alert(response);
    });
  });
}

function startNavigation(position) {
  Kakao.Navi.start(position);
}

function shareLocation(position) {
  Kakao.Navi.share(position);
}
kakao_init();
