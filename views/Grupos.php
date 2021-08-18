<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Grupos = &$Page;
?>
<?php
$id_escenario = $_GET['ides'];
   
// echo Container("escenario")->id_escenario->CurrentValue;
//	$nombreescnario = ExecuteRow("SELECT nombre_escenario,DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d')  FROM escenario WHERE id_escenario =  = '".$id_escenario."';");
 $escenID = ExecuteRow("SELECT DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d'),nombre_escenario FROM escenario WHERE id_escenario = '".$id_escenario."';");

?>

<style>
.gu-mirror {
  position: fixed !important;
  margin: 0 !important;
  z-index: 9999 !important;
  opacity: 0.8;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
  filter: alpha(opacity=80);
  display: flex;
  flex-direction: row;
  align-items: center;
  background-color: #FFF;
}

.sub-section.ex-moved.gu-mirror {
  flex-direction: column;
  align-items: flex-start;
  width: 23%;
}

.sub-section.ex-moved.gu-mirror .sub-section-title {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: space-between;
  align-items: baseline;
  align-content: stretch;
  position: relative;
  width: 94%;
}

.sub-section.ex-moved.gu-mirror .nested {
  width: 100%;
}

.sub-section.ex-moved.gu-mirror .nested .item {
  width: 94%;
  display: flex;
  justify-content: end;
}

.gu-mirror .item-name,
.gu-mirror .item {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 10px 5px;
  background-color: #FFF;
  justify-content: flex-end;
  position: relative;
}

.gu-mirror .buttons-group {
  display: flex;
  flex-direction: row;
  position: absolute;
  right: 0;
}

.gu-hide {
  display: none !important;
}

.gu-unselectable {
  -webkit-user-select: none !important;
  -moz-user-select: none !important;
  -ms-user-select: none !important;
  user-select: none !important;
}

.gu-transit {
  list-style-type: none;
  opacity: 0.2;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
  filter: alpha(opacity=20);
}

.drag-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.home-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.delete-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.dashboard-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.edit-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.activity-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.calendar-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.contact-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.lead-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.folder-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.settings-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}

.about-image {
  
  height: 20px;
  width: 20px;
  background-position: center;
  background-size: cover;
  display: block;
  margin: 0 10px 0 0;
}





p,
ul {
  margin: 0;
  color: #707070;
  font-size: 14px;
}

ul {
  font-size: 16px;
  list-style-type: none;
}

.navigation {
  background: #EEE;
}

.navigation {
  height: 150px;
  width: 100%;
  display: block;
  border-bottom: 1px solid #ccc;
}

.main-page {
  display: flex;
  flex-direction: row;
}

.side-panel {
  background-color: #EEE;
  border-right: 1px solid #ccc;
  height: 100%;
  width: 300px;
}

.main-content {
  height: 100%;
  width: 100%;
  display: flex;
  flex-direction: row;
}
.main-content .header {
  background-color: #EEEEEE;
  border-bottom: 1px solid #ccc;
}
.main-content .header p {
  padding: 12px 0 12px 16px;
  font-weight: 500;
}
.main-content .home-screen-editor {
 
  height: 100%;
  width: 80%;
}
.main-content .home-screen-editor-content {
  width: 100%;
  border-right: 1px solid #ccc;
  box-sizing: border-box;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  padding-bottom: 1em;
}
.main-content .home-screen-editor-content .list-section {
  width: 40%;
}
.main-content .home-screen-editor-content .list-section .list-header {
  font-weight: bold;
}
.main-content .home-screen-editor-content .list-section .list-header p {
  padding: 16px 0;
}
.main-content .home-screen-editor-content .list-section .list-header .banner {
  border: 1px solid #ccc;
  width: 100%;
  height: 128px;
}
.main-content .home-screen-editor-content .list-section .nested .buttons-group {
  display: flex;
  flex-direction: row;
  position: absolute;
  right: 5%;
}
.main-content .home-screen-editor-content .list-section .nested .buttons-group span {
  margin: 0 5px;
  opacity: 0.1;
  cursor: pointer;
}
.main-content .home-screen-editor-content .list-section .nested .buttons-group .active-home {
  opacity: 1;
}
.main-content .home-screen-editor-content .list-section .nested .item:hover .buttons-group span {
  opacity: 1;
}
.main-content .home-screen-editor-content .list-section .nested .item-name:hover .buttons-group span {
  opacity: 1;
}
.main-content .home-screen-editor-content .list-section .empty-folder {
  height: 2.6em;
}
.main-content .home-screen-editor-content .list-section .item,
.main-content .home-screen-editor-content .list-section .item-name {
  padding: 10px 5px;
  background-color: #FFF;
  border: 1px solid #ccc;
  display: flex;
  align-items: center;
  position: relative;
}
.main-content .home-screen-editor-content .list-section .item .entity-name,
.main-content .home-screen-editor-content .list-section .item-name .entity-name {
  padding: 10px 5px;
  background-color: #FFF;
}
.main-content .home-screen-editor-content .list-section .section-item {
  background-color: #EBF5FB;
}
.main-content .home-screen-editor-content .list-section .sub-section {
  border: none;
  background-color: transparent;
  padding: 0 0 0 30px;
}
.main-content .home-screen-editor-content .list-section .sub-section .sub-section-title {
  display: block;
  padding: 10px;

  position: relative;
}
.main-content .home-screen-editor-content .list-section .sub-section .sub-section-titlee {
  display: block;
  padding: 10px;
  background-color: #E5E7E9;
  position: relative;
}
.main-content .home-screen-editor-content .list-section .sub-section .sub-section-title .buttons-group {
  top: 27%;
}
.main-content .home-screen-editor-content .list-section .sub-section .drag-image,
.main-content .home-screen-editor-content .list-section .sub-section .delete-image {
  padding: 0;
}
.main-content .available-items {
  background-color: #FFFFFF;
  height: 100%;
  width: 20%;
}
.main-content .available-items .list .group-header {

  padding: 1em;
  font-weight: bold;
}
.main-content .available-items .list .item-name {
  font-size: 14px;
  background-color: #FFF;
  padding: 1em;
  border-bottom: 1px solid #ccc;
  display: flex;
}
.main-content .gu-transit {
  list-style-type: none;
}
</style>

<body>
  
<div class="callout callout-primary">
  <h4><?php echo $Language->TablePhrase("grupos", "simu"); ?> <?php echo $escenID[2];  ?>  </h4>
 <p> <em> <?php echo $Language->TablePhrase("grupos", "fir"); ?>  <?php echo $escenID[0]  ?> <?php echo $Language->TablePhrase("grupos", "ffr"); ?>  <?php echo $escenID[1];  ?> </em></p>
</div>

    <div class="main-page" id="vue-chat">
      <div class="col-md-3">
          <div class="available-items card">
          <div class="card-header">
                <h3 class="card-title">
                <i class="fa fa-users" aria-hidden="true"></i>
                <?php echo $Language->TablePhrase("grupos", "usu"); ?> 
                </h3>
            </div>
            <div class="card-body">
             
                    <div class="list" id="vue-admin">
                        <div id="available-items" >
                            <div class="nested" v-for="usuario in usuarios">
                                <div class="item-name border" id="{{usuario.id}}" ><span class="drag-image"></span> <i class="fa fa-user-plus" aria-hidden="true"></i>  {{usuario.nombre}}</div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                

            </div>

        </div>
        <div class="main-content card" >
            <div class="home-screen-editor">
                <div class="card-header">
                <h3 class="card-title">
                <i class="fa fa-users" aria-hidden="true"></i>
                <?php echo $Language->TablePhrase("grupos", "gys"); ?> 
                </h3>
                </div>
                <div class="home-screen-editor-content">
                    <section class="list-section" >
                        
                        <div class="list" >
                             <div id="list-section" id="vue-chat">
                                <div class="container" ><!--PENDIENTE-->
                                  <div v-for="elemento in elementos" class="{{elemento.tipo}}" id="{{elemento.id}}">

                                  <div class="nombre-Grupo" v-if="'grupo'==elemento.tipo" id="{{elemento.id}}">
                                        <div class="item ex-moved section-item" id="{{elemento.id}}"> 
                                            <span class="drag-image"></span> <h6> <i class="fa fa-users" aria-hidden="true"></i> <strong> <?php echo $Language->TablePhrase("grupos", "grup"); ?>    {{elemento.nombre}}</strong> </h6>
                                            <div class="buttons-group">
                                                <span class="delete-image"></span>
                                            </div>
                                        </div>
                                    </div>
                                   
                                  
                                      <div class="nested {{elemento.id}}"  v-if="elemento.tipo == 'usuario grupo'">
                                        <div class="item ex-moved{{elemento.id}}" >
                                            <span class="drag-image"></span>
                                            <span class="dashboard-image"></span> <i class="fa fa-user-times" aria-hidden="true"></i> <?php echo $Language->TablePhrase("grupos", "exc"); ?>  {{elemento.nombre}}
                                           
                                        </div>

                                    </div>
                                     
                                      
                                  
                                   <div class="nested-gris" v-if="elemento.tipo == 'subgrupo'" >
                                        <div class="sub-section ex-moved">
                                            <div class="sub-section-titlee item"><span id="{{elemento.id}}"></span> <i class="fa fa-users" aria-hidden="true"></i> <?php echo $Language->TablePhrase("grupos", "subg"); ?>  {{elemento.nombre}}
                                                <div class="buttons-group">

                                                </div>
                                            </div>
                                            
                                  </div>
                                </div>
                                <div class="nested" v-if="elemento.tipo == 'usuario subgrupo'" >
                                        <div class="sub-section ex-moved">
                                            <div class="sub-section-title item"><span id="{{elemento.id}}"></span><i class="fa fa-user-plus" aria-hidden="true"></i> {{elemento.nombre}}
                                                <div class="buttons-group">
                                                    <span class="home-image"></span>
                                                    <span class="delete-image"></span>
                                                </div>
                                            </div>
                                            
                                  </div>
                                </div>
                                
                                                    
                                    
                            </div>
                          </div>
                      </div>
                    </div>

                      
                    </section>
                    </div>
                </div>
                
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</body>

</html>
<!-- partial -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
 <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">

</body>
</html>
<!--JAVA SCRIP--->
<script>
  !function(e){if("object"==typeof exports&&"undefined"!=typeof module)module.exports=e();
else if("function"==typeof define&&define.amd)define([],e);
else{var n;
n="undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:this,n.dragula=e()}}(function(){return function e(n,t,r){function o(u,c){if(!t[u]){if(!n[u]){var a="function"==typeof require&&require;
if(!c&&a)return a(u,!0);
if(i)return i(u,!0);
var f=new Error("Cannot find module '"+u+"'");
throw f.code="MODULE_NOT_FOUND",f}var l=t[u]={exports:{}};
n[u][0].call(l.exports,function(e){var t=n[u][1][e];
return o(t?t:e)},l,l.exports,e,n,t,r)}return t[u].exports}for(var i="function"==typeof require&&require,u=0;
u<r.length;
u++)o(r[u]);
return o}({1:[function(e,n,t){"use strict";
function r(e){var n=u[e];
return n?n.lastIndex=0:u[e]=n=new RegExp(c+e+a,"g"),n}function o(e,n){var t=e.className;
t.length?r(n).test(t)||(e.className+=" "+n):e.className=n}function i(e,n){e.className=e.className.replace(r(n)," ").trim()}var u={},c="(?:^|\\s)",a="(?:\\s|$)";
n.exports={add:o,rm:i}},{}],2:[function(e,n,t){(function(t){"use strict";
function r(e,n){function t(e){return-1!==le.containers.indexOf(e)||fe.isContainer(e)}function r(e){var n=e?"remove":"add";
o(S,n,"mousedown",O),o(S,n,"mouseup",L)}function c(e){var n=e?"remove":"add";
o(S,n,"mousemove",N)}function m(e){var n=e?"remove":"add";
w[n](S,"selectstart",C),w[n](S,"click",C)}function h(){r(!0),L({})}function C(e){ce&&e.preventDefault()}function O(e){ne=e.clientX,te=e.clientY;
var n=1!==i(e)||e.metaKey||e.ctrlKey;
if(!n){var t=e.target,r=T(t);
r&&(ce=r,c(),"mousedown"===e.type&&(p(t)?t.focus():e.preventDefault()))}}function N(e){if(ce){if(0===i(e))return void L({});
if(void 0===e.clientX||e.clientX!==ne||void 0===e.clientY||e.clientY!==te){if(fe.ignoreInputTextSelection){var n=y("clientX",e),t=y("clientY",e),r=x.elementFromPoint(n,t);
if(p(r))return}var o=ce;
c(!0),m(),D(),B(o);
var a=u(W);
Z=y("pageX",e)-a.left,ee=y("pageY",e)-a.top,E.add(ie||W,"gu-transit"),K(),U(e)}}}function T(e){if(!(le.dragging&&J||t(e))){for(var n=e;
v(e)&&t(v(e))===!1;
){if(fe.invalid(e,n))return;
if(e=v(e),!e)return}var r=v(e);
if(r&&!fe.invalid(e,n)){var o=fe.moves(e,r,n,g(e));
if(o)return{item:e,source:r}}}}function X(e){return!!T(e)}function Y(e){var n=T(e);
n&&B(n)}function B(e){$(e.item,e.source)&&(ie=e.item.cloneNode(!0),le.emit("cloned",ie,e.item,"copy")),Q=e.source,W=e.item,re=oe=g(e.item),le.dragging=!0,le.emit("drag",W,Q)}function P(){return!1}function D(){if(le.dragging){var e=ie||W;
M(e,v(e))}}function I(){ce=!1,c(!0),m(!0)}function L(e){if(I(),le.dragging){var n=ie||W,t=y("clientX",e),r=y("clientY",e),o=a(J,t,r),i=q(o,t,r);
i&&(ie&&fe.copySortSource||!ie||i!==Q)?M(n,i):fe.removeOnSpill?R():A()}}function M(e,n){var t=v(e);
ie&&fe.copySortSource&&n===Q&&t.removeChild(W),k(n)?le.emit("cancel",e,Q,Q):le.emit("drop",e,n,Q,oe),j()}function R(){if(le.dragging){var e=ie||W,n=v(e);
n&&n.removeChild(e),le.emit(ie?"cancel":"remove",e,n,Q),j()}}function A(e){if(le.dragging){var n=arguments.length>0?e:fe.revertOnSpill,t=ie||W,r=v(t),o=k(r);
o===!1&&n&&(ie?r&&r.removeChild(ie):Q.insertBefore(t,re)),o||n?le.emit("cancel",t,Q,Q):le.emit("drop",t,r,Q,oe),j()}}function j(){var e=ie||W;
I(),z(),e&&E.rm(e,"gu-transit"),ue&&clearTimeout(ue),le.dragging=!1,ae&&le.emit("out",e,ae,Q),le.emit("dragend",e),Q=W=ie=re=oe=ue=ae=null}function k(e,n){var t;
return t=void 0!==n?n:J?oe:g(ie||W),e===Q&&t===re}function q(e,n,r){function o(){var o=t(i);
if(o===!1)return!1;
var u=H(i,e),c=V(i,u,n,r),a=k(i,c);
return a?!0:fe.accepts(W,i,Q,c)}for(var i=e;
i&&!o();
)i=v(i);
return i}
function U(e){function n(e){
  le.emit(e,f,ae,Q)}
  function t(){s&&n("over")}function r(){
    ae&&n("out")}
    if(J){
      //e.preventDefault();
var o=y("clientX",e),i=y("clientY",e),u=o-Z,c=i-ee;
J.style.left=u+"px",J.style.top=c+"px";
var f=ie||W,l=a(J,o,i),d=q(l,o,i),s=null!==d&&d!==ae;
(s||null===d)&&(r(),ae=d,t());
var p=v(f);
if(d===Q&&ie&&!fe.copySortSource)return void(p&&p.removeChild(f));
var m,h=H(d,l);
if(null!==h)m=V(d,h,o,i);
else{if(fe.revertOnSpill!==!0||ie)return void(ie&&p&&p.removeChild(f));
m=re,d=Q}(null===m&&s||m!==f&&m!==g(f))&&(oe=m,d.insertBefore(f,m),le.emit("shadow",f,d,Q))}}function _(e){E.rm(e,"gu-hide")}function F(e){le.dragging&&E.add(e,"gu-hide")}function K(){if(!J){var e=W.getBoundingClientRect();
J=W.cloneNode(!0),J.style.width=d(e)+"px",J.style.height=s(e)+"px",E.rm(J,"gu-transit"),E.add(J,"gu-mirror"),fe.mirrorContainer.appendChild(J),o(S,"add","mousemove",U),E.add(fe.mirrorContainer,"gu-unselectable"),le.emit("cloned",J,W,"mirror")}}function z(){
console.log(J);
let idUsuarioNuevo=J.id;
console.log(idUsuarioNuevo);
  J&&(E.rm(fe.mirrorContainer,"gu-unselectable"),o(S,"remove","mousemove",U),v(J).removeChild(J),J=null);
console.log("eliminando");
actualizarGrupo(idUsuarioNuevo,0, 0);
window.location.reload();
}function H(e,n){for(var t=n;
t!==e&&v(t)!==e;
)t=v(t);
return t===S?null:t}function V(e,n,t,r){function o(){var n,o,i,u=e.children.length;
for(n=0;
u>n;
n++){if(o=e.children[n],i=o.getBoundingClientRect(),c&&i.left+i.width/2>t)return o;
if(!c&&i.top+i.height/2>r)return o}return null}function i(){var e=n.getBoundingClientRect();
return u(c?t>e.left+d(e)/2:r>e.top+s(e)/2)}function u(e){return e?g(n):n}var c="horizontal"===fe.direction,a=n!==e?i():o();
return a}function $(e,n){return"boolean"==typeof fe.copy?fe.copy:fe.copy(e,n)}var G=arguments.length;
1===G&&Array.isArray(e)===!1&&(n=e,e=[]);
var J,Q,W,Z,ee,ne,te,re,oe,ie,ue,ce,ae=null,fe=n||{};
void 0===fe.moves&&(fe.moves=l),void 0===fe.accepts&&(fe.accepts=l),void 0===fe.invalid&&(fe.invalid=P),void 0===fe.containers&&(fe.containers=e||[]),void 0===fe.isContainer&&(fe.isContainer=f),void 0===fe.copy&&(fe.copy=!1),void 0===fe.copySortSource&&(fe.copySortSource=!1),void 0===fe.revertOnSpill&&(fe.revertOnSpill=!1),void 0===fe.removeOnSpill&&(fe.removeOnSpill=!1),void 0===fe.direction&&(fe.direction="vertical"),void 0===fe.ignoreInputTextSelection&&(fe.ignoreInputTextSelection=!0),void 0===fe.mirrorContainer&&(fe.mirrorContainer=x.body);
var le=b({containers:fe.containers,start:Y,end:D,cancel:A,remove:R,destroy:h,canMove:X,dragging:!1});
return fe.removeOnSpill===!0&&le.on("over",_).on("out",F),r(),le}function o(e,n,r,o){var i={mouseup:"touchend",mousedown:"touchstart",mousemove:"touchmove"},u={mouseup:"pointerup",mousedown:"pointerdown",mousemove:"pointermove"},c={mouseup:"MSPointerUp",mousedown:"MSPointerDown",mousemove:"MSPointerMove"};
t.navigator.pointerEnabled?w[n](e,u[r],o):t.navigator.msPointerEnabled?w[n](e,c[r],o):(w[n](e,i[r],o),w[n](e,r,o))}function i(e){if(void 0!==e.touches)return e.touches.length;
if(void 0!==e.which&&0!==e.which)return e.which;
if(void 0!==e.buttons)return e.buttons;
var n=e.button;
return void 0!==n?1&n?1:2&n?3:4&n?2:0:void 0}function u(e){var n=e.getBoundingClientRect();
return{left:n.left+c("scrollLeft","pageXOffset"),top:n.top+c("scrollTop","pageYOffset")}}function c(e,n){return"undefined"!=typeof t[n]?t[n]:S.clientHeight?S[e]:x.body[e]}function a(e,n,t){var r,o=e||{},i=o.className;
return o.className+=" gu-hide",r=x.elementFromPoint(n,t),o.className=i,r}function f(){return!1}function l(){return!0}function d(e){return e.width||e.right-e.left}function s(e){return e.height||e.bottom-e.top}function v(e){return e.parentNode===x?null:e.parentNode}function p(e){return"INPUT"===e.tagName||"TEXTAREA"===e.tagName||"SELECT"===e.tagName||m(e)}function m(e){return e?"false"===e.contentEditable?!1:"true"===e.contentEditable?!0:m(v(e)):!1}function g(e){function n(){var n=e;
do n=n.nextSibling;
while(n&&1!==n.nodeType);
return n}return e.nextElementSibling||n()}function h(e){return e.targetTouches&&e.targetTouches.length?e.targetTouches[0]:e.changedTouches&&e.changedTouches.length?e.changedTouches[0]:e}function y(e,n){var t=h(n),r={pageX:"clientX",pageY:"clientY"};
return e in r&&!(e in t)&&r[e]in t&&(e=r[e]),t[e]}var b=e("contra/emitter"),w=e("crossvent"),E=e("./classes"),x=document,S=x.documentElement;
n.exports=r}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{"./classes":1,"contra/emitter":5,crossvent:6}],3:[function(e,n,t){n.exports=function(e,n){return Array.prototype.slice.call(e,n)}},{}],4:[function(e,n,t){"use strict";
var r=e("ticky");
n.exports=function(e,n,t){e&&r(function(){e.apply(t||null,n||[])})}},{ticky:9}],5:[function(e,n,t){"use strict";
var r=e("atoa"),o=e("./debounce");
n.exports=function(e,n){var t=n||{},i={};
return void 0===e&&(e={}),e.on=function(n,t){return i[n]?i[n].push(t):i[n]=[t],e},e.once=function(n,t){return t._once=!0,e.on(n,t),e},e.off=function(n,t){var r=arguments.length;
if(1===r)delete i[n];
else if(0===r)i={};
else{var o=i[n];
if(!o)return e;
o.splice(o.indexOf(t),1)}return e},e.emit=function(){var n=r(arguments);
return e.emitterSnapshot(n.shift()).apply(this,n)},e.emitterSnapshot=function(n){var u=(i[n]||[]).slice(0);
return function(){var i=r(arguments),c=this||e;
if("error"===n&&t["throws"]!==!1&&!u.length)throw 1===i.length?i[0]:i;
return u.forEach(function(r){t.async?o(r,i,c):r.apply(c,i),r._once&&e.off(n,r)}),e}},e}},{"./debounce":4,atoa:3}],6:[function(e,n,t){(function(t){"use strict";
function r(e,n,t,r){return e.addEventListener(n,t,r)}function o(e,n,t){return e.attachEvent("on"+n,f(e,n,t))}function i(e,n,t,r){return e.removeEventListener(n,t,r)}function u(e,n,t){var r=l(e,n,t);
return r?e.detachEvent("on"+n,r):void 0}function c(e,n,t){function r(){var e;
return p.createEvent?(e=p.createEvent("Event"),e.initEvent(n,!0,!0)):p.createEventObject&&(e=p.createEventObject()),e}function o(){return new s(n,{detail:t})}var i=-1===v.indexOf(n)?o():r();
e.dispatchEvent?e.dispatchEvent(i):e.fireEvent("on"+n,i)}function a(e,n,r){return function(n){var o=n||t.event;
o.target=o.target||o.srcElement,o.preventDefault=o.preventDefault||function(){o.returnValue=!1},o.stopPropagation=o.stopPropagation||function(){o.cancelBubble=!0},o.which=o.which||o.keyCode,r.call(e,o)}}function f(e,n,t){var r=l(e,n,t)||a(e,n,t);
return h.push({wrapper:r,element:e,type:n,fn:t}),r}function l(e,n,t){var r=d(e,n,t);
if(r){var o=h[r].wrapper;
return h.splice(r,1),o}}function d(e,n,t){var r,o;
for(r=0;
r<h.length;
r++)if(o=h[r],o.element===e&&o.type===n&&o.fn===t)return r}var s=e("custom-event"),v=e("./eventmap"),p=t.document,m=r,g=i,h=[];
t.addEventListener||(m=o,g=u),n.exports={add:m,remove:g,fabricate:c}}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{"./eventmap":7,"custom-event":8}],7:[function(e,n,t){(function(e){"use strict";
var t=[],r="",o=/^on/;
for(r in e)o.test(r)&&t.push(r.slice(2));
n.exports=t}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{}],8:[function(e,n,t){(function(e){function t(){try{var e=new r("cat",{detail:{foo:"bar"}});
return"cat"===e.type&&"bar"===e.detail.foo}catch(n){}return!1}var r=e.CustomEvent;
n.exports=t()?r:"function"==typeof document.createEvent?function(e,n){var t=document.createEvent("CustomEvent");
return n?t.initCustomEvent(e,n.bubbles,n.cancelable,n.detail):t.initCustomEvent(e,!1,!1,void 0),t}:function(e,n){var t=document.createEventObject();
return t.type=e,n?(t.bubbles=Boolean(n.bubbles),t.cancelable=Boolean(n.cancelable),t.detail=n.detail):(t.bubbles=!1,t.cancelable=!1,t.detail=void 0),t}}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{}],9:[function(e,n,t){var r,o="function"==typeof setImmediate; r=o?function(e){setImmediate(e)}:function(e){setTimeout(e,0)},n.exports=r},{}]},{},[2])(2)});

(function() {
    const nodelist = document.getElementById('list-section').querySelectorAll('.nested');
    const divyArray = Array.from(nodelist)
    dragula([document.querySelector('#list-section .container'), document.getElementById('special-items'), document.getElementById('available-items')].concat(divyArray), {
        
        copy: function(el, source) {
            return source === document.getElementById('available-items') || source === document.getElementById('special-items')
        },
        accepts: function(el, target) {
          //console.log("Sumado");
          //console.log(target);
            return target !== document.querySelector('#special-items') && target !== document.querySelector('#available-items')
        },
        removeOnSpill: function(el, source) {
            console.log(el, source);

            return true
        }
    }).on('drop', function(el, source) {
        if (!el.classList.contains('ex-moved')) {
            if (el.classList.contains('folder-item')) {
                console.log('folder');
                var groupButtons =
                    '<div class="buttons-group">' +
                    '<span class="home-image"></span>' +
                    '<span class="delete-image"></span>' +
                    '</div>'
            } else if (el.classList.contains('section-item')) {
                var groupButtons =
                    '<div class="buttons-group">' +
                    '<span class="delete-image"></span>' +
                    '</div>';
            } else {
                var groupButtons =
                    '<div class="buttons-group">' +
                    '<span class="edit-image"></span>' +
                    '<span class="home-image"></span>' +
                    '<span class="delete-image"></span>' +
                    '</div>'
            }
            let dragImage = el.children[0].getElementsByClassName('drag-image');
            let defaultIcon = '<span class="settings-image"></span>';
            el.children[0].insertAdjacentHTML('beforeend', groupButtons);
            //console.log("source");
            let idUsuarioNuevo=-1;
            try{
               idUsuarioNuevo=el.getElementsByClassName('item-name').item('span').id;
            }
            catch{
               idUsuarioNuevo=-1;
            }

            if (dragImage[0]) { dragImage[0].insertAdjacentHTML('afterend', defaultIcon); }
            el.className = 'nested ex-moved'+idUsuarioNuevo;

            let buscado='.nested.ex-moved'+idUsuarioNuevo;
            let x=null;
            x=$(buscado).prevAll();
            console.log(x);
            let idGrupo=0;
            let idProb=0;
            for(let i=0; i<x.length;i++)
            {
               if(x[i].className=="grupo")
                {
                  idGrupo=x[i].id;
                  idProb=i;
                  //console.log(x[i]);
                  break;
                }
            }
            let idSubGrupo=0;
            for(let i=0; i<x.length;i++)
            {
               if(x[i].className=="subgrupo" && i<idProb)
                {
                  idSubGrupo=x[i].id;
                  //console.log(x[i]);
                  break;
                }
            }
            el.id=x[x.length-1].id;
            
            //alert(idUsuarioNuevo+' '+idGrupo+' '+idSubGrupo);
            console.log("el id usuario es "+idUsuarioNuevo);//Obtenemos el id
            console.log("el id grupo es "+idGrupo);//Obtenemos el id
            console.log("el id subGrupo es "+idSubGrupo);//Obtenemos el id
            actualizarGrupo(idUsuarioNuevo,idGrupo, idSubGrupo);
            window.location.reload();
        }
    });
})();
$(document).ready(function() {
    $(document).on("click", ".home-image", function() {
        $('.home-image').removeClass('active-home');
        $(this).addClass('active-home')
    });

    $(document).on("click", ".delete-image", function() {
        let item = $(this).closest('.ex-moved');
        let nestedItem = item.parent()
        
        item.remove();
        console.log("removido");
        if (nestedItem.children().length == 0 && nestedItem.parent().hasClass('sub-section')) {
            nestedItem.addClass("empty-folder")
        }
    });
})



var app = new Vue({
        el: '#vue-chat',
        data: {
            usuarios: [],
            grupos: [],
            elementos: []
            
        },
        
    });

   
    var admin = new Vue({
        el: '#vue-admin',
        data: {
            usuarios: [],
            grupos: [],
            elementos: []
        }
    });

   // var publishKey = 'pub-c-74306dc6-f082-4bc8-9e59-18804033f25d';
   // var subscribeKey = 'sub-c-834f0024-caec-11eb-bdc5-4e51a9db8267';
//
   // var pubnub = new CanalPub("canal-01",publishKey,subscribeKey);
   // var pubnubAdmin = new CanalPub("canal-02",publishKey,subscribeKey);

   // pubnub.mensajeLlegado = llegadaComentario;
   // pubnubAdmin.mensajeLlegado = llegandoMensaje;
obtenerUsuarios(0);
  obtenerGrupos();
function obtenerUsuarios(grupo){
        $.ajax({
            url: "inject/usuarios.php?idGrupo="+grupo,
            success: function (es) {
                let respuesta = JSON.parse(es);
                //console.log(respuesta);
                for(let i = 0;i < respuesta.length;i++){
                    let usuario = respuesta[i];
                    admin.usuarios.push(usuario);
                   // console.log("usuario");
                    //console.log(usuario);
                }
                app.usuarios= admin.usuarios;

            },
            error: function (e) {
                console.log(e);
            }
        });
    }
 
function obtenerGrupos(){
  let grups= new Object();
  grups.nombre='';
  grups.tipo='';
  grups.id='-1';
 
  app.elementos.push(grups);
        $.ajax({
            url: "inject/grupos.php?idescenario="+ <?php echo $id_escenario; ?>,
            success: function (es) {
                let respuesta = JSON.parse(es);
//                console.log(respuesta);
                for(let i = 0;i < respuesta.length;i++){
                    let grups = respuesta[i];
                    grups.visible = true;
                    grups.usuarios=[];
                    grups.tipo="grupo";
                    
                    obtenerUsuariosGrupo(grups,grups.usuarios);
                    
                    
                    admin.grupos.push(grups);
                    
                   // console.log(grups);
                   // console.log("Grupo");
                   // console.log(grups);
                }
              app.grupos=admin.grupos;

            },
            error: function (e) {
                console.log(e);
            }
        });

    }
     function obtenerUsuariosGrupo(grupo, lista){
        $.ajax({
            url: "inject/usuarios.php?idGrupo="+grupo.id,
            success: function (es) {
              
                let respuesta = JSON.parse(es);
                //console.log(respuesta);
                grupo.subgrupo=[];
                
                //app.elementos.push(grupo);
                for(let i = 0;i < respuesta.length;i++){
                    let usuario = respuesta[i];
                    usuario.tipo="usuario grupo";
                    lista.push(usuario);
                    //app.elementos.push(usuario);
                   // console.log("usuario");
                    //console.log(usuario);
                }
                grupo.subgrupo=[];
                 obtenerSubGrupo(grupo, grupo.subgrupo,lista);

            },
            error: function (e) {
                console.log(e);
            }
        });
    }
  function obtenerSubGrupo(grupo, lista,usuariosGrupo){
        $.ajax({
            url: "inject/subgrupos.php?idGrupo="+grupo.id,
            success: function (es) {
                let respuesta = JSON.parse(es);
                //console.log(respuesta);
                for(let i = 0;i < respuesta.length;i++){
                    let subgrupo = respuesta[i];
                    subgrupo.usuarios=[];
                    subgrupo.tipo="subgrupo";
                    obtenerUsuariosSubGrupo(subgrupo,subgrupo.usuarios,grupo, usuariosGrupo);
                    lista.push(subgrupo);
                    
                   // console.log("usuario");
                    //console.log(subgrupo);
                    
                }



            },
            error: function (e) {
                console.log(e);
            }
        });
    }
  function obtenerUsuariosSubGrupo(subgrupo, lista, grupo, usuariosGrupo){
        $.ajax({
            url: "inject/usuariosSubgrupo.php?idSubGrupo="+subgrupo.id,
            success: function (es) {
                let respuesta = JSON.parse(es);
                //console.log(respuesta);
                if(!(app.elementos.includes(grupo)))
                {
                  app.elementos.push(grupo);
                console.log(grupo.nombre);
                usuariosGrupo.forEach(g=>{
                  app.elementos.push(g);
                  console.log(g.nombre);
                })

                }
                
                app.elementos.push(subgrupo);
                console.log(subgrupo.nombre);
                for(let i = 0;i < respuesta.length;i++){
                    let usuario = respuesta[i];
                    lista.push(usuario);
                    usuario.tipo="usuario subgrupo";
                   // console.log("usuario");
                    //console.log(usuario);
                    app.elementos.push(usuario);
                    console.log(usuario.nombre);
                }
                
                  //organizar(nuevo);
            },
            error: function (e) {
                console.log(e);
            }
        });
        
    }
    function actualizarGrupo(idUsuarioNuevo,idGrupo, idSubGrupo){
      $.ajax({
            url: "inject/actualizarGrupo.php?idGrupo="+idGrupo+"&idUsuario="+idUsuarioNuevo+"&idSubGrupo="+idSubGrupo,
            success: function (es) {
                let respuesta = JSON.parse(es);
                console.log(respuesta);
                

            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function organizar(x){
      
      console.log("Cambio");
      let nuevo=[]
      let id=0;
      let idSub=0;
      for(let i=0; i<x.length;i++)
        {
        if( x[i].tipo=="usuario grupo" )
        {
          id=x[i].id;
          nuevo.push(x[i]);
        }
            
          else if(x[i].tipo=="grupo")
                  {
                    if(i>0)
                    {


              if(x[i-1].tipo=="usuario grupo" ){
                let subs=[];
                obtenerSubGrupo(x[i-1],subs);
                subs.forEach(m=>{
                  nuevo.push(m);
                })
              }
              else{
                nuevo.push(x[i]);
              }
            
            }else{
                nuevo.push(x[i]);
              }
          }
          else{
            console.log("¿?"+x[i].nombre);
          }

         
          console.log(x[i].nombre);
        }
        app.elementos=nuevo;
        
      
    
  }

</script>


<?= GetDebugMessage() ?>
