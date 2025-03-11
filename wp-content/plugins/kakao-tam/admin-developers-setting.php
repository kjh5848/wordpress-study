<?php
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}
if (is_admin()) {

$validateKakaoDeveloper = new validateKakaoDeveloper();
$validateKakaoLogin = new validateKakaoLogin();
$validateKakaoLoginAfterLanding = new validateKakaoLoginAfterLanding();
$validateKakaoLoginMapping = new validateKakaoLoginMapping();
$validateKakaoLoginSecure = new validateKakaoLoginSecure();
$validateShare = new validateShare();
$validateMe = new validateMe();
$validateChannel = new validateChannel();
$validateChannelChat = new validateChannel(Constants::KAKAOTALK_CHANNEL_CHAT_SAVE,
    Constants::KAKAOTALK_CHANNEL_CHAT_ICON,
    Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY);
$validateKakaoNavi = new validateKakaoNavi();
$validateKakaoMap = new validateKakaoMap();

if ($validateKakaoDeveloper->isPostValidate()) $validateKakaoDeveloper->updatePostShareOption();
if ($validateKakaoLogin->isPostValidate()) $validateKakaoLogin->updatePostKakaoLoginOption();
if ($validateKakaoLoginAfterLanding->isPostValidate()) $validateKakaoLoginAfterLanding->updatePostKakaoLoginAfterLandingOption();
if ($validateKakaoLoginMapping->isPostValidate()) $validateKakaoLoginMapping->updatePostKakaoLoginMappingOption();
if ($validateKakaoLoginSecure->isPostValidate()) $validateKakaoLoginSecure->updatePostKakaoLoginSecureOption();
if ($validateShare->isPostValidate()) $validateShare->updatePostShareOption();
if ($validateMe->isPostValidate()) $validateMe->updatePostShareOption();
if ($validateChannel->isPostValidateChannelAdd()) $validateChannel->updatePostChannelAddOption();
if ($validateChannelChat->isPostValidateChannelChat()) $validateChannelChat->updatePostChannelChatOption();
if ($validateKakaoNavi->isPostValidate()) $validateKakaoNavi->updatePostKakaoNaviOption();
if ($validateKakaoMap->isPostValidate()) $validateKakaoMap->updatePostKakaoMapOption();
?>

<div id="dashboard-widgets-wrap">
    <div id="dashboard-widgets" class="metabox-holder">
        <div id="postbox-container-1" class="postbox-container">
            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                <div id="dashboard_php_nag" class="postbox  php-no-security-updates">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::DEVELOPER_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2 class="hndle ui-sortable-handle">
                                <?php if (!$validateKakaoDeveloper->hasOptionJavaScriptKey()) { ?>
                                    <span aria-hidden="true"
                                          class="dashicons dashicons-warning"></span><span
                                            class="screen-reader-text">경고: </span>
                                <?php } ?>
                                <?php echo Constants::DEVELOPERS_TITLE; ?>
                            </h2>
                        </div>
                        <div class="inside">

                            <p class="bigger-bolder-text">카카오 디벨로퍼스에서 제공하는 SDK, API를 사용하기 위해서 JavaScript Key
                                (앱키)를
                                등록해야합니다.</p>
                            <p class="button-container">
                                <a class="button button-primary" href="https://developers.kakao.com/"
                                   target="_blank" rel="noopener">카카오 디벨로퍼스에 대해 더 알아보세요 <span
                                            class="screen-reader-text">(새탭에서 열기)</span><span
                                            aria-hidden="true" class="dashicons dashicons-external"></span></a>
                                <a class="button button-primary" href="http://dongha.pe.kr"
                                   target="_blank" rel="noopener">플러그인 데모<span
                                            class="screen-reader-text">(새탭에서 열기)</span><span
                                            aria-hidden="true" class="dashicons dashicons-external"></span></a>
                            </p>

                            <div class="input-text-wrap" id="title-wrap">
                                <label for="title">
                                    JavaScript 키 </label>
                                <input type="text" name="<?php echo Constants::JAVASCRIPT_KEY; ?>"
                                       value="<?php echo esc_html($validateKakaoDeveloper->getOptionJavaScriptKey()); ?>"/>
                            </div>

                            <p> ※ <a href="https://developers.kakao.com/"
                                     target="_blank">https://developers.kakao.com/</a>에서
                                "내
                                애플리케이션 &gt; 앱 설정 &gt; 요약 정보 : JavaScript 키" 를 입력하세요.</p>

                            <div class="input-text-wrap" id="title-wrap">
                                <label for="title">
                                    카카오톡 채널 공개 ID </label>
                                <input type="text" name="<?php echo Constants::KAKAOTALK_CHANNEL_ID; ?>"
                                       value="<?php echo esc_html($validateKakaoDeveloper->getOptionKakaotalkChannelId()); ?>"/>
                            </div>
                            <p> ※ <a href="https://developers.kakao.com/"
                                     target="_blank">https://developers.kakao.com/</a>에서
                                "내
                                애플리케이션>제품 설정>카카오 로그인>카카오톡 채널 : 공개 ID" 를 입력하시거나 <a
                                        href="https://center-pf.kakao.com/"
                                        target="_blank">https://center-pf.kakao.com/</a>에서
                                채널 선택 후, 주소창에 표시된 ID를 입력하세요. ex)_TestXy</p>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::DEVELOPERS_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="wp_mail_smtp_reports_widget_lite" class="postbox ">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAO_LOGIN_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2
                                    class="hndle ui-sortable-handle"><?php echo Constants::KAKAO_LOGIN_TITLE; ?></h2>

                        </div>
                        <div class="inside">
                            <label for="title">
                                아이콘 선택 </label>

                            <ul id="the-comment-list" data-wp-lists="list:comment">
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_ICON_ARRAY); $i++) {
                                    ?>
                                    <li class="comment even thread-even depth-1 comment-item approved">
                                        <div class="dashboard-comment-wrap has-row-actions  has-avatar">
                                            <input type="radio"
                                                   name="<?php echo Constants::KAKAO_LOGIN_ICON; ?>"
                                                   value="<?php echo Constants::KAKAO_LOGIN_ICON_ARRAY[$i]; ?>"
                                                <?php checked($validateKakaoLogin->getOptionKakaoLoginIcon(), Constants::KAKAO_LOGIN_ICON_ARRAY[$i]); ?> />
                                            <span style="vertical-align:middle">
                                                    <img src="<?php echo plugins_url('/icon/' . Constants::KAKAO_LOGIN_ICON_ARRAY[$i], __FILE__); ?>"/>
                                                </span>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <label for="title">
                                표시 여부 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_ICON_DISPLAY_ARRAY); $i++) {
                                    ?>
                                    <input type="radio"
                                           name="<?php echo Constants::KAKAO_LOGIN_ICON_DISPLAY; ?>"
                                           value="<?php echo Constants::KAKAO_LOGIN_ICON_DISPLAY_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoLogin->getOptionKakaoLoginIconDisplay(), Constants::KAKAO_LOGIN_ICON_DISPLAY_ARRAY[$i]); ?> />

                                    <?php echo Constants::KAKAO_LOGIN_ICON_DISPLAY_ARRAY[$i]; ?>
                                    <?php
                                }
                                ?>
                            </div>
                            <label for="title">
                                위치 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_ICON_SUBSET_ARRAY); $i++) {
                                    ?>
                                    <input type="radio"
                                           name="<?php echo Constants::KAKAO_LOGIN_ICON_SUBSET; ?>"
                                           value="<?php echo Constants::KAKAO_LOGIN_ICON_SUBSET_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoLogin->getOptionKakaoLoginIconSubset(), Constants::KAKAO_LOGIN_ICON_SUBSET_ARRAY[$i]); ?> />

                                    <?php echo Constants::KAKAO_LOGIN_ICON_SUBSET_ARRAY[$i]; ?>
                                    <?php
                                }
                                ?>
                            </div>
                            <p> ※ 내 애플리케이션>제품 설정>카카오 로그인 : Redirect URI에 <?php echo esc_url(wp_login_url()); ?> 주소를 등록해야 로그인
                                가능합니다. </p>
                            <p> ※ 페이지에 직접 적용 하려면 [kakao_login_shortcode] 태그를 추가하세요. </p>
                            <input type="submit" name="Submit" class="button button-primary"
                                   value="<?php echo Constants::KAKAO_LOGIN_TITLE; ?> 저장"/>
                        </div>
                    </form>
                </div>
                <div id="dashboard_php_nag" class="postbox  php-no-security-updates">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAO_LOGIN_AFTER_LANDING_SAVE; ?>"
                               value="true"/>
                        <div class="postbox-header"><h2 class="hndle ui-sortable-handle">
                                <?php echo Constants::KAKAO_LOGIN_AFTER_LANDING_TITLE; ?>
                            </h2>
                        </div>
                        <div class="inside">
                            <div class="input-text-wrap" id="title-wrap">
                                <label for="title">
                                    Landing path </label>
                                <input type="text" name="<?php echo Constants::KAKAO_LOGIN_AFTER_LANDING; ?>"
                                       id="post-search-input"
                                       size="50"
                                       value="<?php echo esc_html($validateKakaoLoginAfterLanding->getOptionLoginAfterLanding()); ?>"/>
                                <p> ex) /?p=39 </p>
                            </div>
                            <label for="title">
                                로그인 이후, 랜딩 페이지 유형 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE; ?>"
                                           value="<?php echo Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoLoginAfterLanding->getOptionKakaoLoginAfterLandingStateUse(), Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE_ARRAY[$i]); ?> />
                                    <?php echo Constants::KAKAO_LOGIN_AFTER_LANDING_STATE_USE_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                            </div>
                            <label for="title">
                                로그인 이후, 카카오 로그인 버튼 표시 여부 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE; ?>"
                                           value="<?php echo Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoLoginAfterLanding->getOptionKakaoLoginAfterDisplayStateUse(), Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE_ARRAY[$i]); ?> />
                                    <?php echo Constants::KAKAO_LOGIN_AFTER_DISPLAY_STATE_USE_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                            </div>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAO_LOGIN_AFTER_LANDING_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="dashboard_php_nag" class="postbox  php-no-security-updates">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAO_LOGIN_MAPPING_SAVE; ?>"
                               value="true"/>
                        <div class="postbox-header"><h2 class="hndle ui-sortable-handle">
                                <?php echo Constants::KAKAO_LOGIN_MAPPING_TITLE; ?>
                            </h2>
                        </div>
                        <div class="inside">
                            <label for="title">
                                동일 이메일 기존 회원 매핑 방식 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_MAPPING_STATE_USE_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAO_LOGIN_MAPPING_STATE_USE; ?>"
                                           value="<?php echo Constants::KAKAO_LOGIN_MAPPING_STATE_USE_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoLoginMapping->getOptionKakaoLoginMappingStateUse(), Constants::KAKAO_LOGIN_MAPPING_STATE_USE_ARRAY[$i]); ?> />
                                    <?php echo Constants::KAKAO_LOGIN_MAPPING_STATE_USE_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                            </div>
                            <br/>
                            <label for="title">
                                가입 시, 기본 회원 등급
                            </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_USER_ROLE_USE_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAO_LOGIN_USER_ROLE_USE; ?>"
                                           value="<?php echo Constants::KAKAO_LOGIN_USER_ROLE_USE_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoLoginMapping->getOptionKakaoLoginUserRoleUse(), Constants::KAKAO_LOGIN_USER_ROLE_USE_ARRAY[$i]); ?> />
                                    <?php echo Constants::KAKAO_LOGIN_USER_ROLE_USE_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                            </div>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAO_LOGIN_MAPPING_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="dashboard_php_nag" class="postbox  php-no-security-updates">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAO_LOGIN_SECURE_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2 class="hndle ui-sortable-handle">
                                <?php echo Constants::KAKAO_LOGIN_SECURE_TITLE; ?>
                            </h2>
                        </div>
                        <div class="inside">
                            <div class="input-text-wrap" id="title-wrap">
                                <label for="title">
                                    Client Secret </label>
                                <input type="text" name="<?php echo Constants::CLIENT_SECRET; ?>"
                                       id="post-search-input"
                                       size="50"
                                       value="<?php echo esc_html($validateKakaoLoginSecure->getOptionClientSecret()); ?>"/>
                            </div>

                            <p> ※ <a href="https://developers.kakao.com/"
                                     target="_blank">https://developers.kakao.com/</a>에서
                                "내
                                애플리케이션>제품 설정>카카오 로그인>보안 : Client Secret 키"를 활성화하고 입력하세요.</p>


                            <label for="title">
                                State Parameter 사용 여부 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAO_LOGIN_SECURE_STATE_USE_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAO_LOGIN_SECURE_STATE_USE; ?>"
                                           value="<?php echo Constants::KAKAO_LOGIN_SECURE_STATE_USE_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoLoginSecure->getOptionKakaoLoginSecureStateUse(), Constants::KAKAO_LOGIN_SECURE_STATE_USE_ARRAY[$i]); ?> />
                                    <?php echo Constants::KAKAO_LOGIN_SECURE_STATE_USE_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                            </div>
                            <p> ※ 카카오로그인(인가코드요청)시점에 생성한 난수를 액세스 토큰발급 시점에 체크하여 외부에서 인가 코드 요청 할 수 없도록 보안을 강화합니다. </p>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAO_LOGIN_SECURE_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="postbox-container-2" class="postbox-container">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div id="dashboard_php_nag" class="postbox  php-no-security-updates">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAOTALK_SHARE_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2 class="hndle ui-sortable-handle"><span
                                        class="hide-if-no-js"><?php echo Constants::KAKAOTALK_SHARE_TITLE; ?></span>
                            </h2>
                        </div>
                        <div class="inside">
                            <label for="title">
                                아이콘 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_SHARE_ICON_ARRAY); $i++) {
                                    ?>

                                    <input type="radio" class="tog"
                                           name="<?php echo Constants::KAKAOTALK_SHARE_ICON; ?>"
                                           value="<?php echo Constants::KAKAOTALK_SHARE_ICON_ARRAY[$i]; ?>"
                                        <?php checked($validateShare->getOptionShareIcon(), Constants::KAKAOTALK_SHARE_ICON_ARRAY[$i]); ?> />
                                    <span style="vertical-align:middle">
                                            <img src="<?php echo plugins_url('/icon/' . Constants::KAKAOTALK_SHARE_ICON_ARRAY[$i], __FILE__); ?>"/>
                                        </span>

                                    <?php
                                }
                                ?>
                            </div>

                            <label for="title">
                                위치 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_SHARE_ICON_DISPLAY_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAOTALK_SHARE_ICON_DISPLAY; ?>"
                                           value="<?php echo Constants::KAKAOTALK_SHARE_ICON_DISPLAY_ARRAY[$i]; ?>"
                                        <?php checked($validateShare->getOptionShareIconDisplay(), Constants::KAKAOTALK_SHARE_ICON_DISPLAY_ARRAY[$i]); ?> />
                                    <?php echo Constants::KAKAOTALK_SHARE_ICON_DISPLAY_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_SHARE_ICON_SUBSET_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAOTALK_SHARE_ICON_SUBSET; ?>"
                                           value="<?php echo Constants::KAKAOTALK_SHARE_ICON_SUBSET_ARRAY[$i]; ?>"
                                        <?php checked($validateShare->getOptionShareIconSubSet(), Constants::KAKAOTALK_SHARE_ICON_SUBSET_ARRAY[$i]); ?>/>
                                    <?php echo Constants::KAKAOTALK_SHARE_ICON_SUBSET_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                                <p> ※ 공유하기 아이콘은 블로그 게시글에 기본 표시되고, 홈페이지/개별페이지/검색결과에는 표시하지 않습니다.</p>
                                <p> ※ <a href="https://developers.kakao.com/"
                                         target="_blank">https://developers.kakao.com/</a> >내 애플리케이션>앱 설정>플랫폼>Web : 사이트
                                    도메인에 도메인 주소를 등록해야 사용 가능합니다.</p>
                                <p> ※ 페이지에 직접 적용 하려면 [kakaotalk_share_shortcode] 태그를 추가하세요. </p>

                            </div>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAOTALK_SHARE_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>


                <div id="dashboard_php_nag" class="postbox  php-no-security-updates">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAOTALK_ME_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2 class="hndle ui-sortable-handle"><span
                                        class="hide-if-no-js"><?php echo Constants::KAKAOTALK_ME_TITLE; ?> </span>
                            </h2>
                        </div>
                        <div class="inside">
                            <label for="title">
                                아이콘 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_ME_ICON_ARRAY); $i++) {
                                    ?>

                                    <input type="radio" class="tog"
                                           name="<?php echo Constants::KAKAOTALK_ME_ICON; ?>"
                                           value="<?php echo Constants::KAKAOTALK_ME_ICON_ARRAY[$i]; ?>"
                                        <?php checked($validateMe->getOptionShareIcon(), Constants::KAKAOTALK_ME_ICON_ARRAY[$i]); ?>/>
                                    <span style="vertical-align:middle">
                                                    <img src="<?php echo plugins_url('/icon/' . Constants::KAKAOTALK_ME_ICON_ARRAY[$i], __FILE__); ?>"/>
                                                </span>

                                    <?php
                                }
                                ?>
                            </div>

                            <label for="title">
                                위치 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_ME_ICON_DISPLAY_ARRAY); $i++) {
                                    ?>

                                    <input type="radio"
                                           name="<?php echo Constants::KAKAOTALK_ME_ICON_DISPLAY; ?>"
                                           value="<?php echo Constants::KAKAOTALK_ME_ICON_DISPLAY_ARRAY[$i]; ?>"
                                        <?php checked($validateMe->getOptionShareIconDisplay(), Constants::KAKAOTALK_ME_ICON_DISPLAY_ARRAY[$i]); ?>/>
                                    <?php echo Constants::KAKAOTALK_ME_ICON_DISPLAY_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                                <p> ※ <a href="https://developers.kakao.com/"
                                         target="_blank">https://developers.kakao.com/</a> >내 애플리케이션>제품 설정>카카오 로그인>동의항목 : 접근권한 (카카오톡 메시지 전송) 동의 설정을 해야하고 카카오 로그인 시, 동의해야 사용 가능합니다.</p>
                                <p> ※ 메모하기 아이콘은 카카오톡 공유하기 옆에 표시됩니다.</p>
                                <p> ※ 페이지에 직접 적용 하려면 [kakaotalk_me_shortcode] 태그를 추가하세요.</p>

                            </div>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAOTALK_ME_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="postbox-container-3" class="postbox-container">
            <div id="column3-sortables" class="meta-box-sortables ui-sortable">
                <div id="dashboard_site_health" class="postbox ">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAOTALK_CHANNEL_ADD_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2
                                    class="hndle ui-sortable-handle"><?php echo Constants::KAKAOTALK_CHANNEL_ADD_TITLE; ?></h2>
                        </div>
                        <div class="inside">
                            <label for="title">
                                아이콘 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_CHANNEL_ADD_ICON_ARRAY); $i++) {
                                    ?>

                                    <input type="radio" class="tog"
                                           name="<?php echo Constants::KAKAOTALK_CHANNEL_ADD_ICON; ?>"
                                           value="<?php echo Constants::KAKAOTALK_CHANNEL_ADD_ICON_ARRAY[$i]; ?>"
                                        <?php checked($validateChannel->getOptionChannelAddIcon(), Constants::KAKAOTALK_CHANNEL_ADD_ICON_ARRAY[$i]); ?>>
                                    <span style="vertical-align:middle">
                                        <img src="<?php echo plugins_url('/icon/' . Constants::KAKAOTALK_CHANNEL_ADD_ICON_ARRAY[$i], __FILE__); ?>"/>
                                    </span>

                                    <?php
                                }
                                ?>
                            </div>

                            <label for="title">
                                위치 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY_ARRAY); $i++) {
                                    ?>
                                    <input type="radio"
                                           name="<?php echo Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY; ?>"
                                           value="<?php echo Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY_ARRAY[$i]; ?>"
                                        <?php checked($validateChannel->getOptionChannelAddIconDisplay(), Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY_ARRAY[$i]); ?>>
                                    <?php echo Constants::KAKAOTALK_CHANNEL_ADD_ICON_DISPLAY_ARRAY[$i]; ?>
                                    <?php
                                }
                                ?>
                                <p> ※ 채널 친구 추가 아이콘은 우측 하단 플로팅으로 표시합니다.</p>
                                <p> ※ 페이지에 직접 적용 하려면 [kakaotalk_channel_add_shortcode] 태그를 추가하세요. shortcode는 표시 여부, 위치와
                                    무관하게 컨텐츠 하단에
                                    표시합니다.</p>

                            </div>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAOTALK_CHANNEL_ADD_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="dashboard_activity" class="postbox ">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAOTALK_CHANNEL_CHAT_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2
                                    class="hndle ui-sortable-handle"><?php echo Constants::KAKAOTALK_CHANNEL_CHAT_TITLE; ?></h2>
                        </div>
                        <div class="inside">
                            <label for="title">
                                아이콘 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_ARRAY); $i++) {

                                    ?>
                                    <input type="radio" class="tog"
                                           name="<?php echo Constants::KAKAOTALK_CHANNEL_CHAT_ICON; ?>"
                                           value="<?php echo Constants::KAKAOTALK_CHANNEL_CHAT_ICON_ARRAY[$i]; ?>"
                                        <?php checked($validateChannelChat->getOptionChannelChatIcon(), Constants::KAKAOTALK_CHANNEL_CHAT_ICON_ARRAY[$i]); ?>/>
                                    <span style="vertical-align:middle">
                                                <img src="<?php echo plugins_url('/icon/' . Constants::KAKAOTALK_CHANNEL_CHAT_ICON_ARRAY[$i], __FILE__); ?>"/>
                                            </span>

                                    <?php
                                }
                                ?>
                            </div>

                            <label for="title">
                                위치 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY_ARRAY); $i++) {
                                    ?>
                                    <input type="radio"
                                           name="<?php echo Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY; ?>"
                                           value="<?php echo Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY_ARRAY[$i]; ?>"
                                        <?php checked($validateChannelChat->getOptionChannelChatIconDisplay(), Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY_ARRAY[$i]); ?>/>
                                    <?php echo Constants::KAKAOTALK_CHANNEL_CHAT_ICON_DISPLAY_ARRAY[$i]; ?>

                                    <?php
                                }
                                ?>
                                <p> ※ 채널 친구 추가 아이콘은 우측 하단 플로팅으로 표시합니다.</p>
                                <p> ※ 페이지에 직접 적용 하려면 [kakaotalk_channel_chat_shortcode] 태그를 추가하세요. </p>

                            </div>
                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAOTALK_CHANNEL_CHAT_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="postbox-container-4" class="postbox-container">
            <div id="column4-sortables" class="meta-box-sortables ui-sortable">

                <div id="dashboard_activity" class="postbox ">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAONAVI_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2
                                    class="hndle ui-sortable-handle"><?php echo Constants::KAKAONAVI_TITLE; ?></h2>
                        </div>
                        <div class="inside">
                            <label for="title">
                                아이콘 선택 </label>
                            <div>
                                <?php
                                for ($i = 0; $i < count(Constants::KAKAONAVI_ICON_ARRAY); $i++) {

                                    ?>
                                    <input type="radio" class="tog"
                                           name="<?php echo Constants::KAKAONAVI_ICON; ?>"
                                           value="<?php echo Constants::KAKAONAVI_ICON_ARRAY[$i]; ?>"
                                        <?php checked($validateKakaoNavi->getOptionKakaoNaviIcon(), Constants::KAKAONAVI_ICON_ARRAY[$i]); ?>/>
                                    <span style="vertical-align:middle">
                                                <img src="<?php echo plugins_url('/icon/' . Constants::KAKAONAVI_ICON_ARRAY[$i], __FILE__); ?>"/>
                                            </span>

                                    <?php
                                }
                                ?>
                            </div>

                            <div class="input-text-wrap" id="title-wrap">
                                <label for="title">
                                    목적지 </label>
                                <input type="text" name="<?php echo Constants::KAKAONAVI_POSITION; ?>"
                                       id="post-search-input"
                                       value="<?php echo esc_html($validateKakaoNavi->getOptionKakaoNaviPosition()); ?>"/>
                            </div>
                            <p> ※ 카카오 내비 기능은 모바일 환경에서 카카오 내비 앱을 호출 하여 길찾기를 수행합니다. User-Agent가 모바일 환경이 아닌경우 표시하지
                                않습니다. </p>
                            <p> ※ 길 안내하기를 페이지에 직접 적용 하려면 [kakaonavi_shortcode] 태그를 추가하세요. </p>
                            <p> ※ 목적지 공유하기를 페이지에 직접 적용 하려면 [kakaonavi_share_shortcode] 태그를 추가하세요. </p>

                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAONAVI_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="dashboard_activity" class="postbox ">
                    <form method="post" action="">
                        <input type="hidden" name="<?php echo Constants::KAKAOMAP_SAVE; ?>" value="true"/>
                        <div class="postbox-header"><h2
                                    class="hndle ui-sortable-handle"><?php echo Constants::KAKAOMAP_TITLE; ?><img
                                        src="<?php echo plugins_url('/icon/map.png', __FILE__); ?>"
                                        style="width:50px;height:50px;" alt="map"/></h2>
                        </div>
                        <div class="inside">
                            <div class="input-text-wrap" id="title-wrap">
                                <label for="title">
                                    지도 스타일 </label>
                                <input type="text" name="<?php echo Constants::KAKAOMAP_STYLE; ?>"
                                       id="post-search-input"
                                       value="<?php echo esc_html($validateKakaoMap->getOptionKakaoMapStyle()); ?>"/>
                            </div>
                            <div class="input-text-wrap" id="title-wrap">
                                <label for="title">
                                    위치 </label>
                                <input type="text" name="<?php echo Constants::KAKAOMAP_POSITION; ?>"
                                       id="post-search-input"
                                       value="<?php echo esc_html($validateKakaoMap->getOptionKakaoMapPosition()); ?>"/>
                            </div>
                            <p> ※ 지도를 페이지에 직접 적용 하려면 [kakaomap_shortcode] 태그를 추가하세요. </p>

                            <div class="tablenav bottom">
                                <input type="submit" name="Submit" class="button button-primary"
                                       value="<?php echo Constants::KAKAOMAP_TITLE; ?> 저장"/>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <?php
    }
    ?>
