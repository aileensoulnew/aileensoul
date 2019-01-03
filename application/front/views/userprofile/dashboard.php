<?php $user_id = $this->session->userdata('aileenuser'); ?>
<div class="container pt15 main-dashboard">
    <div class="left-part">
        <div class="left-info-box move-middle">
            <div class="dash-left-title">
                <h3><i class="fa fa-info-circle"></i> Information</h3>
            </div>
            <div class="dash-info-box" ng-if="user_bio">
                <h4>
                    <svg id="Capa_1" x="0px" y="0px" viewBox="0 0 65 65"  width="17px" height="16">
                    <g>
                        <g>
                            <path d="M32.5,0C14.58,0,0,14.579,0,32.5S14.58,65,32.5,65S65,50.421,65,32.5S50.42,0,32.5,0z M32.5,61C16.785,61,4,48.215,4,32.5    S16.785,4,32.5,4S61,16.785,61,32.5S48.215,61,32.5,61z" fill="#5c5c5c"/>
                            <circle cx="33.018" cy="19.541" r="3.345" fill="#5c5c5c"/>
                            <path d="M32.137,28.342c-1.104,0-2,0.896-2,2v17c0,1.104,0.896,2,2,2s2-0.896,2-2v-17C34.137,29.237,33.241,28.342,32.137,28.342z    " fill="#5c5c5c"/>
                        </g>
                    </g>
                </svg>
                Bio</h4>
                <p dd-text-collapse dd-text-collapse-max-length="120" dd-text-collapse-text="{{user_bio}}" dd-text-collapse-cond="true">{{user_bio}}</p>
            </div>
            <div class="dash-info-box" ng-if="details_data.DOB">
                <h4>
                    <svg id="Capa_1" x="0px" y="0px" viewBox="0 0 65 65"  width="17px" height="16">
                    <g>
                        <g>
                            <path d="M32.5,0C14.58,0,0,14.579,0,32.5S14.58,65,32.5,65S65,50.421,65,32.5S50.42,0,32.5,0z M32.5,61C16.785,61,4,48.215,4,32.5    S16.785,4,32.5,4S61,16.785,61,32.5S48.215,61,32.5,61z" fill="#5c5c5c"/>
                            <circle cx="33.018" cy="19.541" r="3.345" fill="#5c5c5c"/>
                            <path d="M32.137,28.342c-1.104,0-2,0.896-2,2v17c0,1.104,0.896,2,2,2s2-0.896,2-2v-17C34.137,29.237,33.241,28.342,32.137,28.342z    " fill="#5c5c5c"/>
                        </g>
                    </g>
                </svg>
                Field</h4>
                <p>{{details_data.Industry}}</p>
            </div>
            <div class="dash-info-box" ng-if='details_data.DOB'>
                <h4>
                    <svg height="16px" viewBox="-3 0 487 487.78763" width="17px" stroke-width="5" stroke="#5c5c5c"><path d="m480.398438 343.789062v-72c-.023438-22.082031-17.917969-39.976562-40-40h-32v-80c0-4.417968-3.582032-8-8-8h-48c-4.417969 0-8 3.582032-8 8v80h-72v-96c0-4.417968-3.582032-8-8-8h-48c-4.417969 0-8 3.582032-8 8v96h-72v-80c0-4.417968-3.582032-8-8-8h-48c-4.417969 0-8 3.582032-8 8v80h-32c-22.078126.023438-39.972657 17.917969-40 40v72c-.273438 17.167969 8.960937 33.085938 24 41.375v86.625h-16c-4.417969 0-8 3.582032-8 8 0 4.417969 3.582031 8 8 8h464c4.417968 0 8-3.582031 8-8 0-4.417968-3.582032-8-8-8h-16v-86.503906c14.808593-8.585937 23.945312-24.382812 24-41.496094zm-120-184h32v72h-32zm-136-16h32v88h-32zm-136 16h32v72h-32zm-72 112c0-13.257812 10.746093-24 24-24h400c13.257812 0 24 10.742188 24 24v72c-.027344 12.707032-7.527344 24.207032-19.144532 29.359376-12.09375 5.09375-26.0625 2.472656-35.484375-6.664063-6.007812-6.027344-9.375-14.191406-9.371093-22.695313v-32c-.039063-12.082031-6.894532-23.101562-17.710938-28.480468l-.488281-.265625c-1.28125-.605469-2.601563-1.121094-3.953125-1.542969-.796875-.265625-1.527344-.527344-2.320313-.71875-1.023437-.234375-2.058593-.417969-3.101562-.546875-.703125-.101563-1.375-.3125-2.089844-.367187-.382813 0-.75.054687-1.125.039062-.378906-.015625-.792969-.117188-1.210937-.117188-.886719 0-1.742188.183594-2.621094.253907-.882813.074219-1.816406.113281-2.714844.265625-1.382812.257812-2.75.609375-4.085938 1.046875-.722656.222656-1.457031.382812-2.160156.65625-1.492187.605469-2.933594 1.328125-4.3125 2.160156-.503906.289063-1.039062.496094-1.535156.800781-1.867188 1.210938-3.605469 2.613282-5.183594 4.183594-6.027344 5.984375-9.40625 14.136719-9.386718 22.632812v16c0 17.671876-14.324219 32-32 32-17.671876 0-32-14.328124-32-32v-16c-.039063-12.082031-6.894532-23.101562-17.710938-28.480468l-.488281-.265625c-1.28125-.605469-2.601563-1.121094-3.953125-1.542969-.796875-.265625-1.527344-.527344-2.320313-.71875-1.023437-.234375-2.058593-.417969-3.101562-.546875-.703125-.101563-1.375-.3125-2.089844-.367187-.382813 0-.75.054687-1.125.039062-.378906-.015625-.792969-.117188-1.210937-.117188-.886719 0-1.742188.183594-2.621094.253907-.882813.074219-1.816406.113281-2.714844.265625-1.378906.257812-2.742188.609375-4.078125 1.046875-.730469.222656-1.464844.382812-2.167969.65625-1.484375.605469-2.921875 1.324219-4.296875 2.152343-.511719.289063-1.054687.503907-1.550781.800782-1.867188 1.207031-3.605469 2.605468-5.183594 4.175781-6.03125 5.988281-9.410156 14.148437-9.386718 22.648437v48c0 17.671876-14.324219 32-32 32-17.671876 0-32-14.328124-32-32v-48c-.039063-12.082031-6.894532-23.101562-17.710938-28.480468l-.488281-.265625c-1.28125-.605469-2.601563-1.121094-3.953125-1.542969-.796875-.265625-1.527344-.527344-2.320313-.71875-1.023437-.234375-2.058593-.417969-3.101562-.546875-.703125-.101563-1.375-.3125-2.089844-.367187-.710937-.054688-1.535156-.078126-2.335937-.078126-17.671876 0-32 14.324219-32 32v32c.011718 8.476563-3.332032 16.613282-9.304688 22.628907-7.929688 7.632812-19.136719 10.8125-29.894531 8.480469-1.914063-.40625-3.789063-.984376-5.597657-1.734376-3.65625-1.613281-6.988281-3.875-9.832031-6.679687-6.007812-6.027344-9.375-14.191406-9.371093-22.695313zm24 200v-80.664062c.800781.132812 1.601562.167969 2.402343.261719l.613281.066406c7 .722656 14.074219-.097656 20.722657-2.402344 2.03125-.714843 4.015625-1.566406 5.933593-2.542969.410157-.199218.800782-.417968 1.226563-.640624 1.550781-.84375 3.058594-1.769532 4.511719-2.777344.464844-.316406.933594-.613282 1.390625-.949219 12.246093-8.910156 19.402343-23.210937 19.199219-38.351563v-32c-.007813-4.246093 1.683593-8.316406 4.695312-11.304687.800781-.792969 1.679688-1.503906 2.625-2.113281.167969-.101563.351562-.175782.519531-.269532.785157-.480468 1.605469-.890624 2.457031-1.226562.25-.09375.503907-.152344.753907-.230469.78125-.265625 1.582031-.464843 2.398437-.601562.382813-.0625.800782-.078125 1.175782-.121094.671874-.0625 1.347656-.085937 2.023437-.070313.503906.023438 1.007813.074219 1.503906.152344.601563.070313 1.199219.179688 1.785157.328125.199218.046875.382812.121094.574218.175781 6.972656 2.542969 11.578125 9.210938 11.488282 16.632813v46.648437c0 26.507813 21.492187 48 48 48 26.511718 0 48-21.492187 48-48v-48c0-5.433593 2.765624-10.492187 7.335937-13.425781.136719-.085937.296875-.144531.433594-.230469.8125-.496093 1.664062-.921874 2.550781-1.265624.226562-.085938.457031-.136719.679688-.207032.785156-.265625 1.585937-.476562 2.402343-.625.382813-.054687.800781-.078125 1.152344-.113281.671875-.066406 1.351563-.089844 2.03125-.070313.503906.023438 1.003906.074219 1.503906.152344.601563.070313 1.195313.179688 1.785157.328125.199218.046875.382812.121094.574218.175781 6.996094 2.523438 11.632813 9.195313 11.550782 16.632813v14.648437c0 26.507813 21.492187 48 48 48 26.511718 0 48-21.492187 48-48v-16c-.007813-4.246093 1.683593-8.316406 4.695312-11.304687.800781-.792969 1.679688-1.503906 2.625-2.113281.167969-.101563.351562-.175782.527344-.28125.78125-.472656 1.601562-.878906 2.449218-1.214844.25-.09375.511719-.152344.800782-.230469.769531-.265625 1.558594-.464843 2.359375-.601562.382812-.0625.800781-.078125 1.175781-.121094.671875-.0625 1.347656-.085937 2.023438-.070313.503906.023438 1.007812.074219 1.503906.152344.601562.070313 1.199218.179688 1.785156.328125.199219.046875.382812.121094.574219.175781 6.96875 2.546876 11.574219 9.214844 11.480469 16.632813v30.648437c-.011719 12.75 5.042968 24.984376 14.058593 34.007813 1.585938 1.546875 3.277344 2.984375 5.0625 4.304687.519531.375 1.054688.710938 1.601563 1.070313 1.34375.917969 2.703125 1.769531 4.117187 2.542969.5625.304687 1.121094.601562 1.6875.878906 1.613281.800781 3.265625 1.511719 4.953125 2.128906.335938.121094.664063.273438 1.007813.386719 4.390625 1.496094 8.96875 2.359375 13.601562 2.558594h.054688c2.230469.089843 4.464843.023437 6.6875-.199219l.800781-.089844c.800781-.085937 1.601562-.121094 2.402344-.253906v80.664062zm0 0" fill="#5c5c5c"/><path d="m240.398438 111.789062c22.082031-.027343 39.976562-17.921874 40-40 0-19.203124-27.832032-60.472656-33.414063-68.546874-1.574219-2.042969-4.003906-3.242188-6.585937-3.242188-2.578126 0-5.011719 1.199219-6.582032 3.242188-5.585937 8.074218-33.417968 49.34375-33.417968 68.546874.027343 22.078126 17.921874 39.972657 40 40zm0-89.539062c11.511718 17.992188 24 40.800781 24 49.539062 0 13.253907-10.742188 24-24 24-13.253907 0-24-10.746093-24-24 0-8.738281 12.488281-31.546874 24-49.539062zm0 0" fill="#5c5c5c"/><path d="m376.398438 127.789062c22.082031-.027343 39.976562-17.921874 40-40 0-19.203124-27.832032-60.472656-33.414063-68.546874-1.574219-2.042969-4.003906-3.242188-6.585937-3.242188-2.578126 0-5.011719 1.199219-6.582032 3.242188-5.585937 8.074218-33.417968 49.34375-33.417968 68.546874.027343 22.078126 17.921874 39.972657 40 40zm0-89.539062c11.511718 17.992188 24 40.800781 24 49.539062 0 13.253907-10.742188 24-24 24-13.253907 0-24-10.746093-24-24 0-8.738281 12.488281-31.546874 24-49.539062zm0 0" fill="#5c5c5c"/><path d="m104.398438 127.789062c22.082031-.027343 39.976562-17.921874 40-40 0-19.203124-27.832032-60.472656-33.414063-68.546874-1.574219-2.042969-4.003906-3.242188-6.585937-3.242188-2.578126 0-5.011719 1.199219-6.582032 3.242188-5.585937 8.074218-33.417968 49.34375-33.417968 68.546874.027343 22.078126 17.921874 39.972657 40 40zm0-89.539062c11.511718 17.992188 24 40.800781 24 49.539062 0 13.253907-10.742188 24-24 24-13.253907 0-24-10.746093-24-24 0-8.738281 12.488281-31.546874 24-49.539062zm0 0" fill="#5c5c5c"/></svg>
                Birthday</h4>
                <p>{{details_data.DOB}}</p>
            </div>
            
            <div class="dash-info-box" ng-if="user_education.length > 0">
                <h4>
                    <svg  viewBox="0 0 349.2 349.2" width="17px" height="16px" stroke-width="5" stroke="#5c5c5c">
                        <g>
                        	<g>
                        		<path d="M337.6,114.25l-139.2-68c-12-6-32.4-6-44.4,0l-142.4,68c-10,4.8-11.6,11.6-11.6,15.2c0,3.6,1.6,10,11.6,15.2l11.6,5.6v64    c-7.2,2.8-12.4,10-12.4,18s5.2,15.2,12,18l-18,57.2h50.4l-18-57.2c7.2-2.8,12-10,12-18c0-8.4-5.2-15.2-12.4-18v-57.2l21.2,10.4    v83.2c0,1.2,0.4,2.4,1.2,3.6c2,2.4,39.2,53.2,115.2,53.2s113.2-51.2,114.8-53.2c0.8-1.2,1.2-2.4,1.2-3.6v-82.8l47.2-23.2    c10-4.8,11.6-11.6,11.6-15.2C348.8,125.85,347.6,119.05,337.6,114.25z M277.6,248.65c-6.4,8-40.8,46.4-103.2,46.4    c-62.4,0-96.8-38.4-103.2-46.4v-75.6l82.8,39.6c6,2.8,14,4.4,22,4.4c8.4,0,16.4-1.6,22.4-4.8l79.2-38.8V248.65z M332,133.45    l-48,23.6c-2,0-3.6,0.8-4.4,2.4l-86.8,42c-8.4,4.4-24.8,4.4-33.6,0l-106.8-51.2l122.8-14.4c3.6-0.4,6-3.6,5.6-6.8    c-0.4-3.6-3.6-6-6.8-5.6l-142.4,16.8l-14.4-6.8c-3.6-1.6-4.4-3.6-4.4-3.6c0-0.4,0.8-2,4.4-3.6l142.4-68.4c4.4-2,10.4-3.2,16.4-3.2    c6.4,0,12.8,1.2,16.8,3.2l139.2,68c3.6,1.6,4.4,3.2,4.4,4C336.4,129.85,335.2,131.85,332,133.45z" fill="#5c5c5c"/>
                        	</g>
                        </g>
                    </svg>
                Education</h4>
                <ul ng-repeat="user_edu in user_education">
                    <li ng-if="user_edu.end_date_str == '' || user_edu.end_date_str == null">Studying at {{user_edu.edu_school_college}}</li>
                    <li ng-if="user_edu.end_date_str != '' && user_edu.end_date_str != null">Studied at {{user_edu.edu_school_college}}</li>
                </ul>
            </div>
            <div class="dash-info-box" ng-if="user_experience.length > '0'">
                <h4>
                    <svg  id="Layer_1" viewBox="0 0 512 512"  width="17px" height="16px" stroke-width="5" stroke="#5c5c5c">
                        <g>
                        	<g>
                        		<path d="M469.333,106.667H362.667V85.333c0-23.531-19.135-42.667-42.667-42.667H192c-23.531,0-42.667,19.135-42.667,42.667v21.333    H42.667C19.135,106.667,0,125.802,0,149.333v277.333c0,23.531,19.135,42.667,42.667,42.667h426.667    c23.531,0,42.667-19.135,42.667-42.667V149.333C512,125.802,492.865,106.667,469.333,106.667z M170.667,85.333    C170.667,73.573,180.24,64,192,64h128c11.76,0,21.333,9.573,21.333,21.333v21.333H170.667V85.333z M490.667,426.667    c0,11.76-9.573,21.333-21.333,21.333H42.667c-11.76,0-21.333-9.573-21.333-21.333V271.4c6.301,3.674,13.527,5.934,21.333,5.934    h170.667v32c0,5.896,4.771,10.667,10.667,10.667h64c5.896,0,10.667-4.771,10.667-10.667v-32h170.667    c7.806,0,15.033-2.259,21.333-5.934V426.667z M234.667,298.667V256h42.667v42.667H234.667z M490.667,234.667    c0,11.76-9.573,21.333-21.333,21.333H298.667v-10.667c0-5.896-4.771-10.667-10.667-10.667h-64    c-5.896,0-10.667,4.771-10.667,10.667V256H42.667c-11.76,0-21.333-9.573-21.333-21.333v-85.333    c0-11.76,9.573-21.333,21.333-21.333h426.667c11.76,0,21.333,9.573,21.333,21.333V234.667z" fill="#5c5c5c"/>
                        	</g>
                        </g>
                    </svg>
                Experience</h4>
                <ul ng-repeat="user_exp in user_experience">                    
                    <li>{{user_exp.designation}} at {{user_exp.exp_company_name}}</li>
                </ul>
            </div>
            <div class="dash-info-box" ng-if="user_skills.length > '0'">
                <h4>
                    <svg width="17px" height="16px" viewBox="0 0 2133.000000 2133.000000">

                    <g transform="translate(0.000000,2133.000000) scale(0.100000,-0.100000)"
                    fill="#5c5c5c" stroke="none">
                    <path d="M8800 21304 c-529 -81 -974 -188 -1470 -354 -1547 -515 -2916 -1458
                    -3961 -2726 -1102 -1337 -1783 -2994 -1938 -4714 -34 -367 -43 -971 -21 -1310
                    125 -1944 834 -3691 2099 -5165 171 -200 638 -672 831 -840 517 -450 1071
                    -834 1647 -1141 l92 -49 4 -1455 c3 -1562 1 -1495 53 -1720 118 -518 418 -994
                    830 -1316 258 -203 605 -368 916 -438 263 -59 123 -56 2861 -56 1613 0 2544 4
                    2602 10 957 107 1758 801 1995 1731 59 230 63 276 70 854 7 539 7 540 33 637
                    99 372 379 653 745 749 53 14 134 23 262 29 315 16 479 44 715 121 758 249
                    1343 884 1530 1659 56 234 58 267 62 941 l4 626 157 6 c188 6 283 27 420 92
                    198 94 344 231 459 430 220 382 251 970 84 1610 -48 183 -14 81 -621 1851
                    l-498 1451 -6 164 c-16 387 -40 657 -87 984 -212 1476 -815 2891 -1737 4075
                    -394 505 -896 1017 -1389 1417 -1206 979 -2646 1615 -4173 1843 l-199 30
                    -1108 -1 -1108 -1 -155 -24z m1575 -1214 c532 -24 1005 -93 1496 -216 1639
                    -411 3089 -1378 4116 -2745 922 -1227 1431 -2700 1469 -4249 3 -129 10 -260
                    16 -290 6 -30 253 -764 551 -1630 297 -866 555 -1626 573 -1688 56 -189 94
                    -405 94 -539 l0 -52 -352 -3 c-335 -4 -357 -5 -423 -27 -199 -65 -350 -212
                    -423 -413 l-27 -73 -5 -980 -6 -980 -27 -99 c-94 -348 -350 -617 -687 -725
                    -104 -33 -163 -41 -370 -51 -388 -18 -644 -82 -965 -240 -606 -298 -1053 -850
                    -1220 -1504 -62 -247 -67 -308 -75 -886 -5 -347 -11 -540 -19 -570 -64 -248
                    -183 -439 -362 -583 -100 -81 -265 -166 -389 -199 l-85 -23 -2515 0 -2515 0
                    -90 28 c-370 114 -629 382 -728 752 -21 80 -21 82 -27 1760 l-5 1680 -23 65
                    c-39 108 -91 191 -168 268 -69 67 -87 78 -276 171 -352 171 -664 349 -958 549
                    -1423 966 -2470 2399 -2955 4045 -367 1250 -397 2589 -84 3842 252 1011 700
                    1928 1348 2765 303 391 753 852 1146 1173 1405 1149 3190 1748 4970 1667z"/>
                    <path d="M9930 17804 c-111 -23 -224 -86 -311 -173 -90 -91 -30 25 -859 -1656
                    -309 -627 -563 -1141 -564 -1142 0 -1 -656 -96 -1456 -212 -800 -116 -1489
                    -220 -1530 -231 -170 -48 -324 -176 -399 -331 -102 -213 -89 -460 35 -647 36
                    -53 293 -310 1115 -1111 588 -573 1069 -1049 1069 -1058 0 -9 -112 -673 -250
                    -1475 -137 -802 -250 -1483 -250 -1513 0 -31 7 -90 16 -132 62 -302 323 -513
                    634 -513 174 0 119 -26 1566 735 727 382 1326 695 1331 695 5 0 596 -309 1313
                    -686 718 -378 1337 -698 1375 -711 97 -34 244 -42 349 -19 238 53 430 242 491
                    481 32 127 30 140 -235 1689 l-251 1460 103 101 c57 56 540 528 1075 1049
                    1035 1008 1022 995 1078 1146 36 99 45 261 21 365 -55 233 -242 425 -467 480
                    -35 8 -716 110 -1514 225 -797 116 -1453 214 -1457 218 -4 4 -302 604 -662
                    1334 -360 730 -668 1347 -685 1371 -47 69 -163 170 -235 206 -136 67 -299 87
                    -446 55z m594 -3012 c240 -485 449 -902 465 -926 43 -62 132 -146 195 -185
                    111 -67 138 -72 1178 -223 544 -79 988 -146 988 -150 0 -4 -323 -322 -717
                    -707 -395 -385 -732 -722 -750 -748 -83 -124 -118 -254 -109 -403 3 -52 79
                    -522 170 -1045 90 -522 163 -951 162 -952 -1 -1 -395 205 -876 458 -481 253
                    -909 472 -950 487 -65 23 -91 26 -200 27 -103 0 -138 -4 -195 -22 -41 -13
                    -437 -216 -950 -486 -484 -255 -881 -460 -883 -456 -2 4 71 442 162 973 183
                    1061 185 1083 145 1226 -31 114 -74 185 -174 289 -49 51 -381 377 -738 724
                    -356 347 -644 634 -640 637 5 4 436 69 958 144 523 75 984 145 1026 156 147
                    36 278 124 362 242 24 35 242 463 482 951 241 488 442 884 446 880 4 -4 204
                    -405 443 -891z"/>
                    </g>
                    </svg>
                Skills</h4>
                <ul class="skill-list">
                    <li ng-repeat="skills in user_skills">{{skills.name}}</li>
                </ul>
            </div>
            <!-- <table width="100%">
                <tr>
                    <td><img src = "<?php //echo base_url('assets/n-images/user.png?ver=' . time()) ?>"></td>
                    <td>{{details_data.fullname}}</td>
                </tr>
                <tr>
                    <td><img src = "<?php //echo base_url('assets/n-images/designation.png?ver=' . time()) ?>"></td>
                    <td ng-if="details_data.Designation !==undefined">
                        {{details_data.Designation}}
                    </td>
                    <td ng-if="details_data.Degree !==undefined">
                        {{details_data.Degree}}
                    </td>

                </tr>
                <tr>
                    <td><img src = "<?php //echo base_url('assets/n-images/industry.png?ver=' . time()) ?>"></td>
                    <td>
                        <span ng-if="details_data.Industry !==undefined">{{details_data.Industry}}</span>
                        <span ng-if="details_data.University !==undefined">{{details_data.University}}</span>
                    </td>
                </tr>
                <tr>
                    <td><img src = "<?php //echo base_url('assets/n-images/location-lb.png?ver=' . time()) ?>"></td>
                    <td>{{details_data.City}}</td>
                </tr>
                 <tr>
                    <td><img src = "<?php //echo base_url('assets/n-images/dob.png?ver=' . time()) ?>"></td>
                    <td>{{details_data.DOB}}</td>
                </tr>
            </table> -->
        </div>
        <div class="media-box latest_photos">
            <div class="dash-left-title" liveslug="{{live_slug}}" userslug="{{user_slug}}">
                <h3>
                    <?php if($user_id != ""): ?>
                        <a href="<?php echo base_url(); ?>{{user_slug}}/photos" ng-click='makeActive("dashboard")'><i class="fa fa-camera"></i> Photos</a>
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#regmodal"><i class="fa fa-camera"></i> Photos</a>
                <?php endif; ?>
                </h3>
            </div>
            <div class="media-display">
                <div class="all-meda" ng-repeat="imageData in postImageData">
                    <img ng-if="imageData.filetype == 'profile_picture'" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{imageData.filename}}" alt="Image" ng-click="openModal2('myModalImage');currentSlide2($index + 1,'Image')">
                    <img ng-if="imageData.filetype == 'cover_picture'" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{imageData.filename}}" alt="Image" ng-click="openModal2('myModalImage');currentSlide2($index + 1,'Image')">
                    <img ng-if="imageData.filetype == 'image'" ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{imageData.filename}}" alt="Image" ng-click="openModal2('myModalImage');currentSlide2($index + 1,'Image')">
                </div>
            </div>
        </div>
        <div class="media-box latest_video">
            <div class="dash-left-title">
                <h3>
                    <?php if($user_id != ""): ?>
                        <a href="<?php echo base_url(); ?>{{user_slug}}/videos" ng-click='makeActive("dashboard")'>
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#regmodal">
                    <?php endif; ?><i class="fa fa-video-camera"></i> Video</a></h3>
            </div>
            <div class="media-display">
                <div class="all-meda" ng-repeat="videoData in postVideoData">
                    <a href="#" ng-click="openModal2('myModalVideo');currentSlide2($index + 1,'Video')">
                        <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{videoData.filename | removeLastCharacter}}png" alt="Image">
                    </a>
                </div>
            </div>
        </div>
        <div class="media-box latest_audio">
            <div class="dash-left-title">
                <h3>
                    <?php if($user_id != ""): ?>
                        <a href="<?php echo base_url(); ?>{{user_slug}}/audios" ng-click='makeActive("dashboard")'>
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#regmodal">
                    <?php endif; ?>
                    <i class="fa fa-music"></i> Audio</a></h3>
            </div>
            <div class="media-display">
                <div class="all-meda" ng-repeat="audioData in postAudioData">
                    <a href="#" ng-click="openModal2('myModalAudio');currentSlide2($index + 1,'Audio')">
                        <label dd-text-collapse dd-text-collapse-max-length="30" dd-text-collapse-text="{{audioData.description}}" dd-text-collapse-cond="false" class="audio-title" ng-if="audioData.post_for == 'simple'">{{audioData.description}}</label>
                        <label dd-text-collapse dd-text-collapse-max-length="30" dd-text-collapse-text="{{post.simple_data.description}}" dd-text-collapse-cond="false" class="audio-title" ng-if="audioData.post_for == 'opportunity'">{{audioData.opportunity}}</label>
                        <div class = "audio_main_div">
                            <div class = "audio_img">
                                <img src = "<?php echo base_url('assets/images/music-icon.png?ver=' . time()) ?>" alt="music-icon.png">
                            </div>
                            <div class = "audio_source">
                                <audio id = "audio_player" width = "100%" height = "40" controls>
                                    <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{audioData.filename}}" type="audio/mp3">
                                    Your browser does not support the audio tag.
                                </audio>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="media-box latest_pdf">
            <div class="dash-left-title">
                <h3>
                    <?php if($user_id != ""): ?>
                        <a href="{{user_slug}}/pdf" ng-click='makeActive("dashboard")'>
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#regmodal">
                    <?php endif; ?>
                        <i class="fa fa-file-pdf-o"></i> PDF</a></h3>
            </div>
            <div class="media-display"  ng-repeat="pdfData in postPdfData">
                <div class="all-meda">
                    <?php if($user_id != ""): ?>
                        <a href="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{pdfData.filename}}" target="_blank">
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#regmodal">
                    <?php endif; ?>
                        <label dd-text-collapse dd-text-collapse-max-length="30" dd-text-collapse-text="{{pdfData.description}}" dd-text-collapse-cond="false" class="pdf-title" ng-if="pdfData.post_for == 'simple'">{{pdfData.description}}</label>
                        <label dd-text-collapse dd-text-collapse-max-length="30" dd-text-collapse-text="{{post.simple_data.description}}" dd-text-collapse-cond="false" class="pdf-title" ng-if="pdfData.post_for == 'opportunity'">{{pdfData.opportunity}}</label>
                        <img ng-src="<?php echo base_url('assets/images/PDF.jpg?ver=' . time()) ?>">
                    </a>
                </div>
            </div>
        </div>
        <div class="media-box articles-cs">
            <div class="dash-left-title">                
                <?php if($user_id != ""): ?>
                    <h3><a href="<?php echo base_url(); ?>{{user_slug}}/article" ng-click='makeActive("dashboard")'><i class="fa fa-file"></i> Article</a></h3>
                <?php else: ?>
                    <h3><a href="#" data-toggle="modal" data-target="#regmodal"><i class="fa fa-file"></i> Article</a></h3>
            <?php endif; ?>
            </div>
            <div class="media-display" >
                <div class="all-meda" ng-repeat="articleData in postArticleData">
                    <a href="{{articleData.article_slug}}" target="_self">
                        <div ng-class="articleData.article_featured_image == '' ? 'article-img default-img' : 'article-img'">
                            <img ng-if="articleData.article_featured_image == ''" src="<?php echo base_url() ?>assets/img/art-default.jpg">
                            <img ng-if="articleData.article_featured_image != ''" src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{articleData.article_featured_image}}">
                        </div>
                        <div class="article-hover">
                            <span dd-text-collapse dd-text-collapse-max-length="49" dd-text-collapse-text="{{articleData.article_title != '' ? articleData.article_title : 'Untitled'}}" dd-text-collapse-cond="false"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="block-1199 fw">
            <div class="add-box">
                <div class="adv-main-view">
                    <img src="<?php echo base_url('assets/n-images/add.jpg') ?>">
                </div>
            </div>
        </div>

        <!-- <div class="custom_footer_left fw">
            <div class="">
                <ul>
                    <li>
                        <a href="#" target="_blank">
                            <span class="custom_footer_dot"> · </span> About Us 
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="custom_footer_dot"> · </span> Contact Us
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="custom_footer_dot"> · </span> Blogs 
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="custom_footer_dot"> · </span> Privacy Policy 
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="custom_footer_dot"> · </span> Terms &amp; Condition
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="custom_footer_dot"> · </span> Send Us Feedback
                        </a>
                    </li>
                </ul>
            </div>
        </div>	 -->

        <?php echo $left_footer_list_view; ?>
    </div>

        <div class="middle-part">
            <div class="add-post hide" ng-if="live_slug == user_slug">
                <div class="post-box">                
                    <?php
                        if ($leftbox_data['user_image'] != '')
                        { ?> 
                        <div class="post-img">
                            <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                        </div>
                    <?php }
                        else
                        {
                            echo '<div class="post-img no-profile-pic">';
                                if($leftbox_data['user_gender'] == "M")
                                {?>                                
                                    <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <?php
                                }
                                if($leftbox_data['user_gender'] == "F")
                                {
                                ?>
                                    <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                <?php
                                }
                            echo "</div>";
                        } ?>
                    
                    <div class="post-text" data-target="#post-popup" data-toggle="modal" onclick="void(0)">
                        Share opportunities, articles and questions
                    </div>
                </div>
                <div class="post-box-bottom">
                    <ul>
                        <li>
                            <a href="#"  class="opportunity-modal" data-target="#opportunity-popup" data-toggle="modal" id="opportunity-modal">
                                <img src="<?php echo base_url('assets/n-images/post-op.png') ?>"><span><span class="none-479">Post</span> <span>Opportunity</span></span>
                            </a>
                        </li>
                        <li class="pl15">
                            <a href="<?php echo base_url('new-article'); ?>">
                                <img src="<?php echo base_url('assets/n-images/article.png') ?>"><span><span class="none-479">Post</span> <span>Article</span></span>
                            </a>
                        </li>
                        <li class="pl15">
                            <a href="#"  class="ask-question-modal" data-target="#ask-question" data-toggle="modal" id="ask-question-modal">
                                <img src="<?php echo base_url('assets/n-images/ask-qustion.png') ?>"><span><span>Ask Question</span></span>
                            </a>
                        </li>
                    </ul>                    
                </div>
            </div>
            <div class="media-pages-tablet">
    			<ul>
    				<li><a href="{{user_slug}}/photos"><i class="fa fa-camera"></i> Photos</a></li>
    				<li><a href="{{user_slug}}/videos"><i class="fa fa-video-camera"></i> Video</a></li>
    				<li><a href="{{user_slug}}/audios"><i class="fa fa-music"></i> Audio</a></li>
    				<li><a href="{{user_slug}}/pdf"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
    				<li><a href="#"><i class="fa fa-address-card"></i> Article</a></li>
    			</ul>
    		</div>
            <div class="bs-example">
                <div class="progress progress-striped" id="progress_div" style="display: none;">
                    <div class="progress-bar" style="width: 0%;">
                        <span class="sr-only">0%</span>
                    </div>
                </div>
            </div>
			
			
			<div class="tab-add">

				<?php //$this->load->view('infeed_add'); ?>
			</div>
			<div id="move-middle">
			</div>
			<div id="move-middle1">
			</div>
			
            <!-- Repeated Class Start -->
            <div class="all_user_post">
                <div class="user_no_post_avl" ng-if="postData.length == 0">
                    <h3>Post</h3>
                    <div class="user-img-nn">
                        <div class="user_no_post_img">
                            <img src="<?php echo base_url('assets/img/no-post.png?ver=' . time()); ?>" alt="bui-no.png">
                        </div>
                        <div class="art_no_post_text">No Post</div>
                    </div>
                </div>
                <div class="fw post_loader" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
                <div ng-if="postData.length != 0" class="all-post-box" ng-repeat="post in postData" ng-init="postIndex=$index" ng-class="post.post_data.post_for == 'article' ? 'article-post' : ''">
                    <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_data.page}}">
                    <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.page_data.total_record}}">
                    <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.page_data.perpage_record}}">
                    <div class="all-post-top">
                        <div class="post-head">
                            <div class="post-img" ng-if="post.post_data.post_for == 'question'">
                                <?php if($user_id != ""): ?>
                                    <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                <?php else: ?>
                                    <a href="#" data-toggle="modal" data-target="#regmodal">
                                <?php endif; ?>
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                </a>
                            </div>
                            <div class="post-img" ng-if="post.post_data.post_for != 'question' && post.user_data.user_image != ''">
                                <?php if($user_id != ""): ?>
                                    <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                <?php else: ?>
                                    <a href="#" data-toggle="modal" data-target="#regmodal">
                                <?php endif; ?>
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}">
                                </a>
                            </div>
                            <div class="post-img no-profile-pic" ng-if="post.post_data.post_for != 'question' && post.user_data.user_image == ''">
                                <?php if($user_id != ""): ?>
                                    <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                <?php else: ?>
                                    <a href="#" data-toggle="modal" data-target="#regmodal">
                                <?php endif; ?>
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                </a>
                            </div>
                            <div class="post-detail">
                                <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                    <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a><span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                                    <?php if($user_id != ""): ?>
                                        <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.question_data.is_anonymously == '0'"></a>
                                    <?php else: ?>
                                        <a href="#" data-toggle="modal" data-target="#regmodal" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.question_data.is_anonymously == '0'"></a>
                                    <?php endif; ?>
                                    <span class="post-time" ng-if="post.question_data.is_anonymously == '0'">{{post.post_data.time_string}}</span>
                                </div>
                                <div class="fw" ng-if="post.post_data.post_for != 'question'">
                                    <?php if($user_id != ""): ?>
                                    <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname"></a>
                                    <?php else: ?>
                                        <a href="#" data-toggle="modal" data-target="#regmodal" class="post-name" ng-bind="post.user_data.fullname"></a>
                                    <?php endif; ?>
                                    <span class="post-time">{{post.post_data.time_string}}</span>
                                </div>
                                <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                    <span class="post-designation" ng-if="post.user_data.title_name != '' && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.title_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == '' && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.degree_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null && post.question_data.is_anonymously == '0'" ng-bind="CURRENT WORK"></span>
                                </div>
                                <div class="fw" ng-if="post.post_data.post_for != 'question'">
                                    <span class="post-designation" ng-if="post.user_data.title_name != ''" ng-bind="post.user_data.title_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == ''" ng-bind="post.user_data.degree_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null" ng-bind="CURRENT WORK"></span>
                                </div>
                            </div>
                            <div class="post-right-dropdown dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                                <ul class="dropdown-menu"> 
                                    <?php if($user_id != ""): ?>
                                    
                                    <li ng-if="live_slug == post.user_data.user_slug && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update' && post.post_data.post_for == 'article'"><a href="<?php echo base_url();?>edit-article/{{post.article_data.unique_key}}">Edit Post</a></li>

                                    <li ng-if="live_slug == user_slug && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update' && post.post_data.post_for != 'article'"><a href="javascript:void(0);" ng-click="EditPostNew(post.post_data.id, post.post_data.post_for, postIndex)">Edit Post</a></li>
                                    <li><a href="javascript:void(0);" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                                    <li>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for == 'article'" href="<?php echo base_url(); ?>article/{{post.article_data.article_slug}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for == 'opportunity'" href="<?php echo base_url(); ?>o/{{post.opportunity_data.oppslug}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files == '0' && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/post/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files == '0' && (post.post_data.post_for == 'profile_update' || post.post_data.post_for == 'cover_update')" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/photos/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'image'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/photos/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'video'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/videos/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'audio'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/audios/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'pdf'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/pdf/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for == 'question'" ng-href="<?php echo base_url('questions/');?>{{post.question_data.id}}/{{post.question_data.question| slugify}}" target="_blank">Show in new tab</a>
                                    </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#regmodal" class="post-name">Show in new tab</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'opportunity'">
                            <div id="edit-opp-post-{{post.post_data.id}}" style="display: none;">
                                <form id="post_opportunity_edit" name="post_opportunity_edit" ng-submit="post_opportunity_check(event,postIndex)">
                                    <div class="post-box">                        
                                        <div class="post-text">
                                            <!-- <textarea name="description" id="description_edit_{{post.post_data.id}}" class="title-text-area" placeholder="Post Opportunity"></textarea> -->
                                            <div contenteditable="true" data-directive ng-model="sim.description_edit" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Post Opportunity..." id="description_edit_{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>
                                        </div>                        
                                    </div>
                                    <div class="post-field">
                                        <div class="form-group">
                                            <label>Title of Opportunity</label>
                                            <input id="opptitleedit{{post.post_data.id}}"  type="text" class="form-control" ng-model="opp.opptitleedit" placeholder="Enter Title of Opportunity" ng-required="true" autocomplete="off">
                                        </div>
                                        <div id="content" class="form-group">
                                            <label>For whom this opportunity?<a href="#" data-toggle="tooltip" data-placement="left" title="Hooray!" class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" tooltips tooltip-append-to-body="true" tooltip-close-button="true" tooltip-side="right" tooltip-hide-trigger="click" tooltip-template="" alt="tooltip"></a></label>
											
                                            <tags-input id="job_title" ng-model="opp.job_title_edit" display-property="name" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer...." replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
                                                <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                            </tags-input>
                                            <script type="text/ng-template" id="title-template">
                                                <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                            </script>
                                            <script type="text/ng-template" id="title-autocomplete-template">
                                                <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                            </script>
                                        </div>

                                        <div class="form-group">
                                            <label>For which location?<a href="#" data-toggle="tooltip" data-placement="left" title="Enter a word or two then select the location for the opportunity." class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></a></label>
                                            <tags-input id="location" ng-model="opp.location_edit" display-property="city_name" placeholder="Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai...." replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()">
                                                <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                                            </tags-input>
                                            <script type="text/ng-template" id="location-template">
                                                <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                            </script>
                                            <script type="text/ng-template" id="location-autocomplete-template">
                                                <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                            </script>
                                        </div>
                                        <div class="form-group">
                                            <label>For which field?<a href="#" data-toggle="tooltip" data-placement="left" title="Select the field from given options that best match with Opportunity." class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></a></label>
                                            <!--<input name="field" id="field" type="text" placeholder="What is your field?" autocomplete="off">-->
    										<span class="select-field-custom">
    											<select name="field" ng-model="opp.field_edit" id="field_edit{{post.post_data.id}}" ng-change="other_field(this)">
    												<option value="" selected="selected">Select Related Fields</option>
    												<option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
    												<option value="0">Other</option>
    											</select>
    										</span>
                                        </div>
                                        <div class="form-group" ng-if="opp.field_edit == '0'">
                                            <input id="otherField_edit{{post.post_data.id}}" name="otherField_edit{{post.post_data.id}}" type="text" class="form-control" ng-model="opp.otherField_edit" placeholder="Enter other field" ng-required="true" autocomplete="off">
                                        </div>
                                        <input type="hidden" name="post_for" class="form-control" value="">
                                        <input type="hidden" id="opp_edit_post_id{{postIndex}}" name="opp_edit_post_id" class="form-control" value="{{post.post_data.id}}">
                                    </div>
                                    <div class="text-right fw pb10">
                                        <button type="submit" class="btn1" id="save_{{post.post_data.id}}" value="Submit">
                                            <span class="ajax_load" id="login_ajax_load{{post.post_data.id}}" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span>
                                        Save</button>
                                    </div>
                                    <?php // echo form_close(); ?>
                                </form>
                            </div>
                            <div id="post-opp-detail-{{post.post_data.id}}">
                                <h5 class="post-title">
                                    <p ng-if="post.opportunity_data.opptitle"><b>Title of Opportunity:</b><span ng-bind="post.opportunity_data.opptitle" id="opp-title-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.location"><b>Location:</b><span ng-bind="post.opportunity_data.location" id="opp-post-location-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.field"><b>Field:</b><span ng-bind="post.opportunity_data.field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                                </h5>
                                <div class="post-des-detail" ng-if="post.opportunity_data.opportunity">
                                    <div id="opp-post-opportunity-{{post.post_data.id}}" ng-class="post.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                        <b>Opportunity:</b>
                                        <span ng-bind-html="post.opportunity_data.opportunity"></span>
                                        <a id="remove-view-more{{post.post_data.id}}" ng-if="post.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'simple'">
                            <div class="post-des-detail">
                                <div ng-init="limit = 250; moreShown = false">
                                    <span ng-if="post.simple_data.description != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.simple_data.description" ng-class="post.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                    </span>
                                    <a id="remove-view-more{{post.post_data.id}}" ng-if="post.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                    
                                </div>

                                <div id="edit-simple-post-{{post.post_data.id}}" style="display: none;">
                                    <form  id="post_something_edit" name="post_something_edit" ng-submit="post_something_check(event,postIndex)" enctype="multipart/form-data">
                                        <div class="post-box">        
                                            <div class="post-text">
                                                <div contenteditable="true" data-directive ng-model="sim.description_edit" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Share opportunities, articles and questions" id="editPostTexBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>

                                                <!-- <textarea name="description" ng-model="sim.description_edit" id="editPostTexBox-{{post.post_data.id}}" class="title-text-area hide" placeholder="Write something here..."></textarea> -->
                                            </div>                        
                                            <div class="post-box-bottom" >                            
                                                <input type="hidden" name="post_for" class="form-control" value="simple">
                                                <input type="hidden" id="edit_post_id{{postIndex}}" name="edit_post_id" class="form-control" value="{{post.post_data.id}}">
                                                <p class="pull-right">
                                                    <button type="submit" class="btn1" value="Submit">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="post-discription" ng-if="post.post_data.post_for == 'article'">
                            <div ng-init="limit = 100; moreShown = false" class="article-title" ng-if="post.article_data.article_featured_image == ''">
                                <span ng-if="post.article_data.article_title != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.article_data.article_title" ng-class="post.article_data.article_title.length > 100 ? 'view-more-expand' : ''">
                                </span>
                                <a id="remove-view-more{{post.post_data.id}}" ng-if="post.article_data.article_title.length > 100" href="<?php //echo base_url(); ?>article/{{post.article_data.article_slug}}">.... Read More</a>
                            </div>
                            <div ng-init="limit = 100; moreShown = false" class="article-description" ng-if="post.article_data.article_featured_image == ''">
                                <span ng-if="post.article_data.article_desc != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.article_data.article_desc" ng-class="post.article_data.article_desc.length > 100 ? 'view-more-expand' : ''">
                                </span>
                                <a id="remove-view-more{{post.post_data.id}}" ng-if="post.article_data.article_desc.length > 100" href="<?php //echo base_url(); ?>article/{{post.article_data.article_slug}}">.... Read More</a>
                            </div>
                        </div> -->
                        <div class="post-discription" ng-if="post.post_data.post_for == 'article'"></div>
                        <div class="post-images" ng-if="post.post_data.post_for == 'article'">
                            <div class="one-img" ng-class="post.article_data.article_featured_image == '' ? 'article-default-featured' : ''">
                                <a href="<?php echo base_url(); ?>article/{{post.article_data.article_slug}}" target="_self">
                                    <img ng-src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{post.article_data.article_featured_image}}" alt="{{post.article_data.article_title}}" ng-if="post.article_data.article_featured_image != ''">
                                    <img ng-src="<?php echo base_url('assets/img/art-default.jpg'); ?>{{post.article_data.article_featured_image}}" alt="{{post.article_data.article_title}}" ng-if="post.article_data.article_featured_image == ''">
                                    <div class="article-post-text">
                                        <h3>{{post.article_data.article_title}}</h3>
                                        <p>Aileensoul</p>
                                    </div>
                                </a>                            
                            </div>
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'profile_update'">
                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.profile_update.data_value}}" ng-click="openModal2('myModalCoverPic'+post.post_data.id);">
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'cover_update'">
                            <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" ng-if="post.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPic'+post.post_data.id);">                        
                        </div>
                        <div ng-if="post.post_data.post_for == 'profile_update' || post.post_data.post_for == 'cover_update'" id="myModalCoverPic{{post.post_data.id}}" class="modal modal2" style="display: none;">
                            <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModalCoverPic'+post.post_data.id)">×</button>
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                        <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                    </div>
                                    <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                    <div class="mySlides mySlides2{{post.post_data.id}}">
                                        <div class="numbertext"></div>
                                        <div class="slider_img_p" ng-if="post.post_data.post_for == 'cover_update'">
                                            <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" alt="Cover Image" id="cover{{post.post_data.id}}">
                                        </div>
                                        <div class="slider_img_p" ng-if="post.post_data.post_for == 'profile_update'">
                                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.profile_update.data_value}}" alt="Profile Image" id="cover{{post.post_data.id}}">
                                        </div>
                                    </div>                                
                                </div>
                                <div class="caption-container">
                                    <p id="caption"></p>
                                </div>
                            </div>
                        </div>

                        <div class="post-discription" ng-if="post.post_data.post_for == 'question'">
                            <h5 class="post-title">
                                <p ng-if="post.question_data.question"><b>Question:</b><span ng-bind="post.question_data.question" id="ask-post-question-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.question_data.description && post.question_data.description != 'undefined'"><b>Description:</b><span ng-bind="post.question_data.description" id="ask-post-description-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.question_data.link"><b>Link:</b><a href="{{post.question_data.link}}" target="_self" ng-bind="post.question_data.link" id="ask-post-link-{{post.post_data.id}}"></a></p>
                                <p ng-if="post.question_data.category"><b>Category:</b><span ng-bind="post.question_data.category" id="ask-post-category-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.question_data.field"><b>Field:</b><span ng-bind="post.question_data.field" id="ask-post-field-{{post.post_data.id}}"></span></p>
                            </h5>
                            <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity"></span></div>
                        </div>
                        <div class="post-images" ng-if="post.post_data.total_post_files == '1'">
                            <div class="one-img" ng-repeat="post_file in post.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                <a href="#" ng-if="post_file.file_type == 'image'"><img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                <span ng-if="post_file.file_type == 'video'"> 
                                    <?php //if($user_id != ""): ?>
                                    
                                    <video controls width = "100%" height = "350" preload="none" poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}png">
                                        <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" type="video/mp4">
                                    </video>                                
                                    <?php /*else: ?>
                                        <a href="#" data-toggle="modal" data-target="#regmodal">
                                            <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}png">
                                        </a>
                                    <?php endif;*/ ?>
                                </span>
                                <span  ng-if="post_file.file_type == 'audio'" >
                                    <div class = "audio_main_div">
                                        <div class = "audio_img">
                                            <img src = "<?php echo base_url('assets/images/music-icon.png?ver=' . time()) ?>" alt="music-icon.png">
                                        </div>
                                        <div class = "audio_source">
                                            <audio id = "audio_player" width = "100%" height = "40" controls>
                                                <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" type="audio/mp3">
                                                Your browser does not support the audio tag.
                                            </audio>
                                        </div>
                                    </div>
                                    <!--<audio controls ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></audio>-->
                                </span>
                                <a ng-href="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" target="_blank" title="Click Here" ng-if="post_file.file_type == 'pdf'"><img ng-src="<?php echo base_url('assets/images/PDF.jpg?ver=' . time()) ?>"></a>
                            </div>
                        </div>
                        <div class="post-images" ng-if="post.post_data.total_post_files == 2">
                            <div class="two-img" ng-repeat="post_file in post.post_file_data">
                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                            </div>
                        </div>
                        <div class="post-images" ng-if="post.post_data.total_post_files == 3">
                            <span ng-repeat="post_file in post.post_file_data">
                                <div class="three-img-top" ng-if="$index == 0">
                                    <a href="#"><img ng-src="<?php echo USER_POST_RESIZE4_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                </div>
                                <div class="two-img" ng-if="$index == 1">
                                    <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 2,post.post_data.id)"></a>
                                </div>
                                <div class="two-img" ng-if="$index == 2">
                                    <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 3,post.post_data.id)"></a>
                                </div>
                            </span>
                        </div>
                        <div class="post-images four-img" ng-if="post.post_data.total_post_files >= 4">
                            <div class="two-img" ng-repeat="post_file in post.post_file_data| limitTo:4">
                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                <div class="view-more-img" ng-if="$index == 3 && post.post_data.total_post_files > 4">
                                    <span><a href="javascript:void(0);" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)">View All ({{post.post_data.total_post_files - 4}})</a></span>
                                </div>
                            </div>
                        </div>
                        <div id="myModal{{post.post_data.id}}" class="modal modal2" style="display: none;">
                            <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModal'+post.post_data.id)">×</button>
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                    </div>
                                    <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                    <div class="mySlides mySlides2{{post.post_data.id}}" ng-if="post.post_data.post_for != 'article'" ng-repeat="_photoData in post.post_file_data">
                                        <div class="numbertext">{{$index + 1}} / {{post.post_data.total_post_files}}</div>
                                        <div class="slider_img_p">
                                            <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                        </div>
                                    </div>
                                    <!-- <div class="mySlides mySlides2{{post.post_data.id}}" ng-if="post.post_data.post_for == 'article' && post.article_data.article_featured_image != ''">
                                        <div class="numbertext">1</div>
                                        <div class="slider_img_p">
                                            <img ng-src="<?php //echo base_url().$this->config->item('article_featured_upload_path'); ?>{{post.article_data.article_featured_image}}" alt="Image-1" id="element_load_1">
                                        </div>
                                    </div> -->
                                </div>
                                <div class="caption-container">
                                    <p id="caption"></p>
                                </div>
                            </div> 
                            <a ng-if="post.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,post.post_data.id)">&#10094;</a>
                            <a ng-if="post.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,post.post_data.id)">&#10095;</a>
                        </div>
                        <div class="post-bottom">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <ul class="bottom-left">
                                        <li>
                                            <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i></a>
                                            <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i></a>
                                        </li>
                                        <li><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><i class="fa fa-comment-o"></i></a></li>
                                        <li><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><i class="fa fa-comment-o"></i></a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <ul class="pull-right bottom-right">
                                        <li class="like-count" ng-click="like_user_list(post.post_data.id);"><span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span><span>Like</span></li>
                                        <!-- <li class="comment-count"><span class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></li> -->
                                        <li class="comment-count"><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></a></li>
                                        <li class="comment-count"><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="like-other-box">
                            <a href="#" ng-click="like_user_list(post.post_data.id);" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
                        </div>
                    </div>
                    <div class="all-post-bottom comment-for-post-{{post.post_data.id}}">
                        <div class="comment-box">
                            <div class="post-comment" ng-repeat="comment in post.post_comment_data" ng-init="commentIndex=$index">
                                <div class="post-img">
                                    <div ng-if="comment.user_image != ''">
                                        <?php if($user_id != ""): ?>
                                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                        <?php else: ?>
                                            <a href="#" data-toggle="modal" data-target="#regmodal">
                                        <?php endif; ?>
                                            <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{comment.user_image}}">
                                        </a>
                                    </div>
                                    <div class="post-img" ng-if="comment.user_image == ''">
                                        <?php if($user_id != ""): ?>
                                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                        <?php else: ?>
                                            <a href="#" data-toggle="modal" data-target="#regmodal">
                                        <?php endif; ?>
                                            <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" comment.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" comment.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="comment-dis">
                                    <div class="comment-name"><a ng-href="<?php echo base_url() ?>{{comment.user_slug}}" class="post-name" target="_self" ng-bind="comment.username"></a></div>
                                    <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}">
                                        <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{comment.comment}}" dd-text-collapse-cond="true">{{comment.comment}}</p>
                                    </div>
                                    <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                        <div class="comment-input">
                                            <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                            <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}}, post.post_data.id)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)"></div>
                                        </div>
                                        <div class="mob-comment">
                                            <button ng-click="sendEditComment(comment.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                        </div>
                                        
                                        <div class="comment-submit hidden-mob">
                                            <button class="btn2" ng-click="sendEditComment(comment.comment_id, post.post_data.id)">Save</button>
                                        </div>
                                    </div>
                                    <ul class="comment-action">
                                        <li ng-if="comment.is_userlikePostComment == '1'"><a href="javascript:void(0);" ng-click="likePostComment(comment.comment_id, post.post_data.id)" class="like"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>
                                        <li ng-if="comment.is_userlikePostComment == '0'"><a href="javascript:void(0);" ng-click="likePostComment(comment.comment_id, post.post_data.id)"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>
                                        <li ng-if="comment.commented_user_id == user_id" id="edit-comment-li-{{comment.comment_id}}"><a href="javascript:void(0);" ng-click="editPostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex)">Edit</a></li> 
                                        <li id="cancel-comment-li-{{comment.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancelPostComment(comment.comment_id, post.post_data.id, $parent.$index, $index)">Cancel</a></li> 
                                        <li ng-if="post.post_data.user_id == user_id || comment.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deletePostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex, post)">Delete</a></li>
                                        <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="add-comment new-comment-{{post.post_data.id}}">
                                <div class="post-img">
                                    <?php 
                                    if ($leftbox_data['user_image'] != '')
                                    { ?> 
                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                    <?php
                                    }
                                    else
                                    { 
                                        if($leftbox_data['user_gender'] == "M")
                                        {?>                                
                                            <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <?php
                                        }
                                        if($leftbox_data['user_gender'] == "F")
                                        {
                                        ?>
                                            <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        <?php
                                        }                                
                                    } ?>

                                </div>
                                <div class="comment-input">
                                    <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="cmt_handle_paste($event)" ng-keydown="check_comment_char_count(post.post_data.id,$event)"></div>
                                </div>
                                <div class="mob-comment">
                                    <button ng-click="sendEditComment(comment.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/img/send.png') ?>"></button>
                                </div>
                                <div class="comment-submit hidden-mob">
                                    <button class="btn2" ng-click="sendComment(post.post_data.id, $index, post)">Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="tab-add">
						<?php //$this->load->view('banner_add'); ?>
					</div>
            </div>
            <!-- Repeated Class Complete -->
            <div class="fw" id="loader" style="text-align:center; display: block;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
        </div>
        <div class="right-part">
            <div class="right-add-box">        
            </div>            
            <?php
            $all_c_no_login = "";
            if($user_id == ""){
                $all_c_no_login = "hide";
            }
            ?>
            <div class="dashboard-profile <?php echo $all_c_no_login; ?>" ng-if="live_slug == user_slug">
                <div class="">
                    <div id="profile-progress" class="edit_profile_progress all-user-list" style="display: none;">                    
                        <div class="count_main_progress">
                            <div class="circles">
                                <div class="second circle-1">
                                    <div>
                                        <strong></strong>
                                        <span id="progress-txt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="right-info-box move-middle1" ng-if="user_social_links.length > '0' || user_personal_links.length > '0'">                
                <div id="social-link-body">
                    <div class="dtl-dis">
                        <div class="social-links" ng-if="user_social_links.length > '0'">
                            <h4>Social</h4>
                            <ul class="social-link-list">
                                <li ng-repeat="social_links in user_social_links">
                                    <a href="{{social_links.user_links_txt}}" target="_self">
                                        <img ng-if="social_links.user_links_type == 'Facebook'" src="<?php echo base_url(); ?>assets/n-images/detail/fb.png">
                                        <img ng-if="social_links.user_links_type == 'Google'" src="<?php echo base_url(); ?>assets/n-images/detail/g-plus.png">
                                        <img ng-if="social_links.user_links_type == 'LinkedIn'" src="<?php echo base_url(); ?>assets/n-images/detail/in.png">
                                        <img ng-if="social_links.user_links_type == 'Pinterest'" src="<?php echo base_url(); ?>assets/n-images/detail/pin.png">
                                        <img ng-if="social_links.user_links_type == 'Instagram'" src="<?php echo base_url(); ?>assets/n-images/detail/insta.png">
                                        <img ng-if="social_links.user_links_type == 'GitHub'" src="<?php echo base_url(); ?>assets/n-images/detail/git.png">
                                        <img ng-if="social_links.user_links_type == 'Twitter'" src="<?php echo base_url(); ?>assets/n-images/detail/twt.png">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="social-links" ng-if="user_personal_links.length > '0'">
                            <h4 class="pt20 fw">Personal</h4>
                            <ul class="social-link-list">
                                <li ng-repeat="user_p_links in user_personal_links">
                                    <a href="{{user_p_links.user_links_txt}}" target="_self">
                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/pr-web.png">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="all-contact <?php echo $all_c_no_login; ?>">
                <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4>
                <div class="all-user-list">
                    <data-owl-carousel class="owl-carousel" data-options="">
                        <div owl-carousel-item="" ng-repeat="contact in contactSuggetion" class="item">
                            <div class="item" id="item-{{contact.user_id}}">
                                <div class="arti-profile-box">
                                    <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                            <img src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                        </a>
                                    </div>
                                    <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                            <div class="gradient-bg" style="height: 100%"></div>
                                        </a>
                                    </div>
                                    <div class="user-pr-img" ng-if="contact.user_image != ''">
                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                        </a>
                                    </div>
                                    <div class="user-pr-img" ng-if="contact.user_image == ''">
                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                            <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        </a>
                                    </div>
                                    <div class="user-info-text text-center">
                                        <h3>
                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)"></a>
                                        </h3>
                                        <p>
                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null">{{contact.title_name| uppercase}}</a>
                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null">{{contact.degree_name| uppercase}}</a>
                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null">CURRENT WORK</a>
                                        </p>
                                    </div>
                                    <div class="author-btn">
                                        <div class="user-btns">
                                            <a class="btn3 addtobtn-{{contact.user_id}}" ng-click="addToContact(contact.user_id, contact)">Add to Contacts</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div owl-carousel-item="" class="item last-item-box">
                            <div class="arti-profile-box">
                                <div class="find-more">
                                    <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                </div>                            
                                <div class="user-info-text text-center">
                                    <h3>
                                        <a href="<?php echo base_url('contact-request') ?>">Find More Contacts
                                        </a>
                                    </h3>                                
                                </div>
                                <div class="author-btn">
                                    <div class="user-btns">
                                        <a class="btn3" href="<?php echo base_url('contact-request') ?>">View More</a>
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="<?php //echo base_url('contact-request') ?>">
                                <div class="item" id="last-item">
                                    <div class="post-img" ng-if="contact.user_image != ''">
                                        <img ng-src="<?php //echo base_url('assets/n-images/view-all.png') ?>">
                                    </div>
                                    <div class="user-list-detail">
                                        <p class="contact-name">Find More Contacts</p>
                                    </div>
                                    <button class="follow-btn">View More</button> 
                                </div>
                            </a> -->
                        </div>
                    </data-owl-carousel>
                </div>
            </div>

            <!-- <div class="dtl-box">
                <div class="dtl-title">
                    <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/website.png'); ?>"><span>Website</span>
                </div>
                <div class="dtl-dis">
                    <h4>Social</h4>
                    <ul class="social-link-list">
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/fb.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/in.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pin.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/insta.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/you.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/git.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/twt.png'); ?>"></a></li>
                    </ul>
                    <h4 class="pt20 fw">Personal</h4>
                    <ul class="social-link-list">
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web'); ?>.png"></a></li>
                        <li><a href="#"><img src="<?php echo base_url('assets/n-images/detail/pr-web'); ?>.png"></a></li>
                    </ul>
                </div>
            </div> -->
            
        </div>
    </div>
    <div style="display:none;" class="modal fade" id="post-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="post-popup-box">
                    <form  id="post_something" name="post_something" ng-submit="post_something_check(event)" enctype="multipart/form-data">
                        <div class="post-box">
                            <div class="post-img">
                                <?php
                                if ($leftbox_data['user_image'] != '')
                                {
                                    ?>
                                    <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                <?php
                                }
                                else
                                { 
                                    if($leftbox_data['user_gender'] == "M")
                                    {?>                                
                                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <?php
                                    }
                                    if($leftbox_data['user_gender'] == "F")
                                    {
                                    ?>
                                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    <?php
                                    }
                                } ?>
                            </div>
                            <div class="post-text">
                                <textarea name="description" ng-model="sim.description" id="description" class="title-text-area" placeholder="Share opportunities, articles and questions"></textarea>
                            </div>
                            <div class="all-upload" ng-if="is_edit != 1">
                                <div class="form-group">
                                    <div id="fileCountSim"></div>
                                    <div id="selectedFiles" class="file-preview">
                                    </div>
                                    <!-- <input file-input="files" ng-file-model="sim.postfiles" type="file" id="fileInput1" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2" fileInput multiple style="display: none;"> -->
                                    <input type="file" id="fileInput1" name="postfiles[]" multiple style="display: none;">
                                </div>
                                <label for="fileInput1" ng-click="postFiles()">
                                    <i class="fa fa-camera upload_icon" onclick="javascript:$('#fileInput1').attr('accept','image/*');"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon" onclick="javascript:$('#fileInput1').attr('accept','video/*');"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon" onclick="javascript:$('#fileInput1').attr('accept','audio/*');"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon" onclick="javascript:$('#fileInput1').attr('accept','.pdf');"><span class="upload_span_icon"> PDF </span></i>
                                </label>
                            </div>
                            <div class="post-box-bottom" >
                                <ul ng-if="is_edit != 1">
                                    <li>
                                        <a href="#" class="post-opportunity-modal" data-target="#opportunity-popup" data-toggle="modal">
                                            <img src="<?php echo base_url('assets/n-images/post-op.png') ?>"><span>Post Opportunity</span>
                                        </a>
                                    </li>
                                    <li class="pl15">
                                        <a href="article.html">
                                            <img src="<?php echo base_url('assets/n-images/article.png') ?>"><span>Post Article</span>
                                        </a>
                                    </li>
                                    <li class="pl15">
                                        <a href="#" class="ask-question-modal post-ask-question-modal" data-target="#ask-question" data-toggle="modal">
                                            <img src="<?php echo base_url('assets/n-images/ask-qustion.png') ?>"><span>Ask Question</span>
                                        </a>
                                    </li>
                                </ul>
                                <input type="hidden" name="post_for" ng-model="sim.post_for" class="form-control" value="">
                                <input type="hidden" ng-if="is_edit == 1" id="edit_post_id" name="edit_post_id" ng-model="sim.edit_post_id" class="form-control" value="{{sim.edit_post_id}}">
                                <p class="pull-right">
                                    <button type="submit" class="btn1" value="Submit">Post</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none;" class="modal fade" id="opportunity-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="post-popup-box">
                    <form id="post_opportunity" name="post_opportunity" ng-submit="post_opportunity_check(event)">
                        <div class="post-box">
                            <div class="post-img">
                                <?php
                                if ($leftbox_data['user_image'] != '')
                                { ?>
                                    <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                <?php
                                }
                                else
                                { 
                                    if($leftbox_data['user_gender'] == "M")
                                    {?>                                
                                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <?php
                                    }
                                    if($leftbox_data['user_gender'] == "F")
                                    {
                                    ?>
                                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    <?php
                                    } 
                                } ?>
                            </div>
                            <div class="post-text">
                                <textarea name="description" ng-model="opp.description" id="description" class="title-text-area" placeholder="Post Opportunity"></textarea>
                            </div>

                            <div class="all-upload" ng-if="is_edit != 1">
                                <div class="form-group">
                                    
                                    <div id="fileCountOpp"></div>
                                    <div id="selectedFilesOpp" class="file-preview"></div>

                                    <input file-input="files" ng-file-model="opp.postfiles" type="file" id="fileInput" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2" multiple style="display: none;">
                                </div>
                                <label for="fileInput" ng-click="postFiles()">
                                    <i class="fa fa-camera upload_icon" onclick="javascript:$('#fileInput').attr('accept','image/*');"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon" onclick="javascript:$('#fileInput').attr('accept','video/*');"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon" onclick="javascript:$('#fileInput').attr('accept','audio/*');"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon" onclick="javascript:$('#fileInput').attr('accept','.pdf');"><span class="upload_span_icon"> PDF </span></i>
                                </label>
                            </div>
                        </div>
                        <div class="post-field">
                            <div id="content" class="form-group">
                                <label>For whom this opportunity?</label>
								<div id="jobtitletooltip" class="tooltip-custom" style="display: none;">Type the designation which best matches for given opportunity.</div>
                                <tags-input id="job_title" ng-model="opp.job_title" display-property="name" placeholder="Ex: Singer, SEO, HR, Photographer, Designer…" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
                                    <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                </tags-input>
                                <script type="text/ng-template" id="title-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="title-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                            </div>

                            <div class="form-group">
                                <label>For which location?</label>
								<div id="locationtooltip" class="tooltip-custom" style="display: none;">Enter a word or two then select the location for the opportunity.!</div>
                                <tags-input id="location" ng-model="opp.location" display-property="city_name" placeholder="Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai...." replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()">
                                    <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                                </tags-input>
                                <script type="text/ng-template" id="location-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="location-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                            </div>
                            <div class="form-group">
                                <label>For which field?</label>
								<div id="fieldtooltip" class="tooltip-custom" style="display: none;">Select the field from given options that best match with Opportunity.</div>
                                <!--<input name="field" id="field" type="text" placeholder="What is your field?" autocomplete="off">-->
                                <span class="select-field-custom">
                                    <select name="field" ng-model="opp.field" id="field" ng-change="other_field(this)">
                                        <option value="" selected="selected">Select Related Fields</option>
                                        <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                        <option value="0">Other</option>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group" ng-if="opp.field == '0'">
                                <input type="text" class="form-control" ng-model="opp.otherField" placeholder="Enter other field" ng-required="true" autocomplete="off">
                            </div>
                            <input type="hidden" name="post_for" ng-model="opp.post_for" class="form-control" value="">
                            <input type="hidden" ng-if="is_edit == 1" id="opp_edit_post_id" name="opp_edit_post_id" ng-model="opp.edit_post_id" class="form-control" value="{{opp.edit_post_id}}">
                        </div>
                        <div class="text-right fw pt10 pb20 pr15">
                            <button type="submit" class="btn1"  value="Submit">Post</button>    
                        </div>
                        <?php // echo form_close(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none;" class="modal fade" id="ask-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="post-popup-box">
                    <form id="ask_question" name="ask_question" ng-submit="ask_question_check(event)">
                        <div class="post-box">
                            <div class="post-img">
                                <?php
                                if ($leftbox_data['user_image'] != '')
                                { ?>
                                    <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                <?php
                                }
                                else
                                {
                                    if($leftbox_data['user_gender'] == "M")
                                    {?>                                
                                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <?php
                                    }
                                    if($leftbox_data['user_gender'] == "F")
                                    {
                                    ?>
                                        <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    <?php
                                    } 
                                } ?>
                            </div>
                            <div class="post-text">
                                <!-- <textarea class="title-text-area" ng-keyup="questionList()" ng-model="ask.ask_que" id="ask_que" placeholder="Ask Question" typeahead="item as item.question for item in queSearchResult | filter:$viewValue" autocomplete="off"></textarea> -->
                                <textarea class="title-text-area" ng-keyup="questionList()" ng-model="ask.ask_que" id="ask_que" placeholder="Ask Your Question (What you want to ask today?)"></textarea>
                                <ul class="questionSuggetion custom-scroll">
                                    <li ng-repeat="que in queSearchResult">
                                        <a ng-href="<?php echo base_url('questions/') ?>{{que.id}}/{{que.question| slugify}}" target="_self" ng-bind="que.question"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="all-upload" ng-if="is_edit != 1">
                                <div class="form-group">
                                    <div id="fileCountQue"></div>
                                    <div id="selectedFilesQue" class="file-preview"></div>
                                    <input file-input="files" ng-file-model="ask.postfiles" type="file" id="fileInput2" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2" multiple style="display: none;">
                                </div>
                                <label for="fileInput2" ng-click="postFiles()">
                                    <i class="fa fa-camera upload_icon" onclick="javascript:$('#fileInput2').attr('accept','image/*');"><span class="upload_span_icon"> Add Screenshot </span></i>
                                </label>
                                <div class="add-link" ng-click="ShowHide()">
                                    <i class="fa fa fa-link upload_icon"><span class="upload_span_icon"> Add Link</span>  </i> 
                                </div>
                                <div class="form-group"  ng-show = "IsVisible">
                                    <input type="url" ng-model="ask.web_link" class="" placeholder="Add Your Web Link">
                                </div>
                            </div>
                        </div>
                        <div class="post-field">
                            <div class="form-group">
                                <label>Add Description</label>
								<div id="ask_desctooltip" class="tooltip-custom" style="display: none;">Describe your problem in more details with some examples.</div>
                                <textarea rows="1" max-rows="5" ng-model="ask.ask_description" placeholder="Add Description" cols="10" style="resize:none"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Related Categories</label>
								<div id="rlcattooltip" class="tooltip-custom" style="display: none;">Enter a word or two then select a tag that matches with Question. Enter up to 5 tags. Ex: For the question “How to open a saving account?” tags will be “banking”.</div>
                                <tags-input id="ask_related_category" ng-model="ask.related_category" display-property="name" placeholder="Add a Related Category " replace-spaces-with-dashes="false" template="category-template" on-tag-added="onKeyup()">
                                    <auto-complete source="loadCategory($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="category-autocomplete-template"></auto-complete>
                                </tags-input>
                                <script type="text/ng-template" id="category-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="category-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                            </div>
                            <div class="form-group">
                                <label>From which field the Question asked?</label>
								<div id="ask_fieldtooltip" class="tooltip-custom" style="display: none;">Select the field from given options that best match with Question.</div>
                                <span class="select-field-custom">
                                    <select ng-model="ask.ask_field" id="ask_field">
                                        <option value="" selected="selected">Select Related Field</option>
                                        <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                        <option value="0">Other</option>
                                    </select>
                                </span>
                            </div>

                            <div class="form-group" ng-if="ask.ask_field == '0'">
                                <input type="text" class="form-control" ng-model="ask.otherField" placeholder="Enter other field" ng-required="true" autocomplete="off">
                            </div>
                            <input type="hidden" name="post_for" ng-model="ask.post_for" class="form-control" value="">
                            <input type="hidden" ng-if="is_edit == 1" id="ask_edit_post_id" name="ask_edit_post_id" ng-model="ask.edit_post_id" class="form-control" value="{{ask.edit_post_id}}">
                        </div>
                        <div class="text-right fw pt10 pb20 pr15">
                            <div class="add-anonymously">
                                <label class="control control--checkbox" title="Checked this">Add Anonymously<input type="checkbox" ng-model="ask.is_anonymously" value="1"><div class="control__indicator"></div></label>
                            </div>
                            <button type="submit" class="btn1"  value="Submit">Post Your Question</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror post-error" id="posterrormodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="posterror-modal-close modal-close" data-dismiss="modal">&times;
                </button>       
                <div class="modal-body">
                    <span class="mes"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box post-error" id="post" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" id="post" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <span class="mes"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box" id="delete_model" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" id="postedit" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <span class="mes">
                        <div class="pop_content">Do you want to delete this comment?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deleteComment(c_d_comment_id, c_d_post_id, c_d_parent_index, c_d_index, c_d_post)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box" id="delete_post_model" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" id="postedit" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <span class="mes">
                        <div class="pop_content">Do you want to delete this post?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deletedPost(p_d_post_id, p_d_index)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade message-box like-popup" id="likeusermodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                 <button type="button" class="modal-close" data-dismiss="modal">×</button>            
                <h3 ng-if="count_likeUser > 0 && count_likeUser < 2">{{count_likeUser}} Like</h3>
                <h3 ng-if="count_likeUser > 1">{{count_likeUser}} Likes</h3>
                <div class="modal-body padding_less_right">
                    <div class="">
                        <ul>
                            <li class="like-img" ng-repeat="userlist in get_like_user_list">
                                <a class="ripple" href="<?php echo base_url(); ?>{{userlist.user_slug}}" ng-if="userlist.user_image != ''">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{userlist.user_image}}">
                                </a>
                                  <a class="ripple" href="<?php echo base_url(); ?>{{userlist.user_slug}}" ng-if="userlist.user_image == '' || userlist.user_image == null">
                                    <img ng-if="userlist.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <img ng-if="userlist.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                </a>
                                <div class="like-detail">
                                    <h4><a href="<?php echo base_url(); ?>{{userlist.user_slug}}">{{(userlist.user_id == '<?php echo $user_id; ?>' ? 'You' : userlist.fullname)}}</a></h4>
                                    <p ng-if="(userlist.degree_name != null) && (userlist.title_name == null)">{{userlist.degree_name}}</p>
                                    <p ng-if="(userlist.title_name != null) && (userlist.degree_name == null)">{{userlist.title_name}}</p>
                                    <p ng-if="(userlist.title_name == null) && (userlist.degree_name == null)">Current work</p>
                                </div>

                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModalImage" class="modal modal2" style="display: none;">
        <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModalImage')">×</button>
        <div class="modal-dialog">
            <div class="modal-content">
                <?php //if($user_id != ""): ?>
                <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                </div>
                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                <div class="mySlides mySlides2Image" ng-repeat="_photoData in postAllImageData">
                    <div class="numbertext">{{$index + 1}} / {{postAllImageData.length}}</div>
                    <div class="slider_img_p">
                        <img ng-if="_photoData.filetype == 'profile_picture'" ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                        <img ng-if="_photoData.filetype == 'cover_picture'" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                        <img ng-if="_photoData.filetype == 'image'" ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                    </div>
                </div>
                <?php /*else: ?>
                    <div class='pop_content pop-content-cus'>
                        <h2>Never miss out any opportunities, news, and updates.</h2>
                        Join Now! 
                        <p class='poppup-btns'>
                            <a class='btn1' href="<?php echo base_url(); ?>login">Login</a> or 
                            <a class='btn1' href="<?php base_url(); ?>registration">Register</a>
                        </p>
                    </div>
                <?php endif;*/ ?>
            </div>
            <div class="caption-container">
                <p id="caption"></p>
            </div>
        </div> 
        <a class="prev" style="left:0px;" ng-click="plusSlides2(-1,'Image')">&#10094;</a>
        <a class="next" ng-click="plusSlides2(1,'Image')">&#10095;</a>
    </div>

    <div id="myModalVideo" class="modal modal2" style="display: none;">
        <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModalVideo')">×</button>
        <div class="modal-dialog">
            <div class="modal-content">     
                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                <div class="mySlides mySlides2Video" ng-repeat="_videoData in postAllVideoData">
                    <div class="numbertext">{{$index + 1}} / {{postAllVideoData.length}}</div>
                    <div class="slider_img_p">
                       <video controls width = "100%" preload="auto">
                            <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_videoData.filename}}#t=0.1" type="video/mp4">
                        </video>
                    </div>
                </div>
                
            </div>
            <div class="caption-container">
                <p id="caption"></p>
            </div>
        </div> 
        <a class="prev" style="left:0px;" ng-click="plusSlides2(-1,'Video')">&#10094;</a>
        <a class="next" ng-click="plusSlides2(1,'Video')">&#10095;</a>
    </div>

    <div id="myModalAudio" class="modal modal2" style="display: none;">
        <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModalAudio')">×</button>
        <div class="modal-dialog">
            <div class="modal-content">     
                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                <div class="mySlides mySlides2Audio" ng-repeat="_audioData in postAllAudioData">
                    <div class="numbertext">{{$index + 1}} / {{postAllAudioData.length}}</div>
                    <div class="slider_img_p">
                        <div class = "audio_main_div">
                            <label dd-text-collapse dd-text-collapse-max-length="70" dd-text-collapse-text="{{_audioData.description}}" dd-text-collapse-cond="false" class="audio-title" ng-if="_audioData.post_for == 'simple'">{{_audioData.description}}</label>
                            <label dd-text-collapse dd-text-collapse-max-length="70" dd-text-collapse-text="{{post.simple_data.description}}" dd-text-collapse-cond="false" class="audio-title" ng-if="_audioData.post_for == 'opportunity'">{{_audioData.opportunity}}</label>
                            <div class = "audio_img">
                                <img src = "<?php echo base_url('assets/images/music-icon.png?ver=' . time()) ?>" alt="music-icon.png">
                            </div>
                            <div class = "audio_source">
                                <audio id = "audio_player" width = "100%" height = "40" controls>
                                    <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_audioData.filename}}" type="audio/mp3">
                                    Your browser does not support the audio tag.
                                </audio>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="caption-container">
                <p id="caption"></p>
            </div>
        </div> 
        <a class="prev" style="left:0px;" ng-click="plusSlides2(-1,'Audio')">&#10094;</a>
        <a class="next" ng-click="plusSlides2(1,'Audio')">&#10095;</a>    
    </div>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
		$(document).ready(function () {
        	if (screen.width <= 991) {
        		$(".move-middle").appendTo($("#move-middle"));
        		$(".move-middle1").appendTo($("#move-middle1"));
	            
	        }
	       
	    });
    </script>