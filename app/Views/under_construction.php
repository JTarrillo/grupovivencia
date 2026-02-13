<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Azbel -  La mejor oportunidad para cambiar tu vida e impactar la vida de miles de personas en el mundo.</title>
      <link rel="stylesheet" type="text/css" href="<?php echo site_url()."assets/under_construction/demo1.css";?>"/>
      <link rel="stylesheet" href="https://looming.w3codemasters.in/css/style.css">
	   <!-- begin favicon -->
      <link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url()."assets/front/img/logo/favicon/apple-touch-icon.png";?>">
      <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url()."assets/front/img/logo/favicon/favicon-32x32.png";?>">
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url()."assets/front/img/logo/favicon/favicon-16x16.png";?>">
      <link rel="mask-icon" href="<?php echo site_url()."assets/front/img/logo/favicon/safari-pinned-tab.svg";?>" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">
      <!-- end favicon -->
		<meta content="ie=edge" http-equiv="x-ua-compatible">
		<meta name="description" content="Nuestra experiencia corporativa nos coloca un paso adelante de la industria" />
		<meta name="keywords" content="Azbel, productos peruano, productos naturales, negocio mlm"/>
		<link rel="canonical" href="<?php echo site_url();?>"/>
		<meta name="author" content="Azbel">
    	<meta name="distribution" content="Global">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo site_url();?>">
		<meta property="og:title" content="Azbel -  La mejor oportunidad para cambiar tu vida e impactar la vida de miles de personas en el mundo.">
		<meta property="og:url" content="<?php echo site_url();?>">
		<meta property="og:description" content="Nuestra experiencia corporativa nos coloca un paso adelante de la industria">
		<meta property="og:image" content="<?php echo site_url()."assets/front/img/bg_azbel.jpg";?>">
		<meta property="og:type" content="video_lecture">
		<meta property="og:site_name" content="Azbel -  La mejor oportunidad para cambiar tu vida e impactar la vida de miles de personas en el mundo.">
		<meta property="og:locale" content="pe">
		<meta itemprop="name" content="Azbel -  La mejor oportunidad para cambiar tu vida e impactar la vida de miles de personas en el mundo.">
		<meta itemprop="url" content="<?php echo site_url();?>">
		<meta itemprop="description" content="Nuestra experiencia corporativa nos coloca un paso adelante de la industria">
		<meta itemprop="image" content="<?php echo site_url()."assets/front/img/bg_azbel.jpg";?>">
		<meta name="twitter:card" content="summary_large_image"> 
		<meta name="twitter:title" content="Azbel -  La mejor oportunidad para cambiar tu vida e impactar la vida de miles de personas en el mundo."> 
   </head>
   <style>
      body {
      padding: 0;
      margin: 0;
      overflow: hidden;
      height: 600px;
      }
      canvas {
      padding: 0;
      margin: 0;
      }
      div.btnbg {
      position: fixed;
      left: 0;
      top: 0;
      }
      .content {
      position: fixed;
      top: 0px;
      text-align: center;
      display: block;
      background-image: url(./images/bg.png);
      margin: 0 auto;
      left: 0;
      color: #fff;
      font-family: sans-serif;
      text-transform: uppercase;
      right: 0;
      height: 100%;
      background-size: cover;
      }
      .content h2 {
      font-size: 100px;
      }
      .time {
      padding: 0px;
      text-align: center;
      }
      .time li {
      display: inline-block;
      width: 240px;
      color: #fff;
      text-align: right;
      text-transform: uppercase;
      }
      .time li b {
      font-size: 100px;
      font-weight: 800;
      line-height: normal;
      font-family: "Open Sans", sans-serif;
      }
      .time li span {
      display: block;
      font-size: 30px;
      }
   </style>
   <body>
      
      <!--  loader -->
      <div class="load">
         <div class="lds-ripple">
            <div></div>
            <div></div>
         </div>
      </div>
      <canvas id="sakura"></canvas>
      <div class="content">
         <div class="inner">
            <h2 class="content__title"> pronto estaremos <b class="wow fadeInUp" data-wow-delay="0.4s">aquí</b></h2>
            <p class="content__text" style="margin: 0 auto 80px !important;">La mejor oportunidad para cambiar tu vida e impactar la vida de miles de personas en el mundo. Nuestra experiencia corporativa nos coloca un paso adelante de la industria.</p>
            <img src="<?php echo site_url()."assets/front/img/logo/logo.png";?>" width="150">
            <ul class="time" id="timer">
               <li class="wow fadeInUp" data-wow-delay="0.7s">
                  <b id="days"></b> <span>days</span>
               </li>
               <li class="wow fadeInUp" data-wow-delay="0.9s"> <b id="hours"></b>
                  <span>hours</span>
               </li>
               <li class="wow fadeInUp" data-wow-delay="1.2s"> <b id="minutes"> </b> <span> minutes</span></li>
               <li class="wow fadeInUp" data-wow-delay="1.3s"> <b id="seconds"> </b> <span>seconds </span></li>
            </ul>
         </div>
      </div>
      <!-- sakura shader -->
      <script id="sakura_point_vsh" type="x-shader/x_vertex">
         uniform mat4 uProjection;
         uniform mat4 uModelview;
         uniform vec3 uResolution;
         uniform vec3 uOffset;
         uniform vec3 uDOF;  //x:focus distance, y:focus radius, z:max radius
         uniform vec3 uFade; //x:start distance, y:half distance, z:near fade start
         
         attribute vec3 aPosition;
         attribute vec3 aEuler;
         attribute vec2 aMisc; //x:size, y:fade
         
         varying vec3 pposition;
         varying float psize;
         varying float palpha;
         varying float pdist;
         
         //varying mat3 rotMat;
         varying vec3 normX;
         varying vec3 normY;
         varying vec3 normZ;
         varying vec3 normal;
         
         varying float diffuse;
         varying float specular;
         varying float rstop;
         varying float distancefade;
         
         void main(void) {
             // Projection is based on vertical angle
             vec4 pos = uModelview * vec4(aPosition + uOffset, 1.0);
             gl_Position = uProjection * pos;
             gl_PointSize = aMisc.x * uProjection[1][1] / -pos.z * uResolution.y * 0.5;
             
             pposition = pos.xyz;
             psize = aMisc.x;
             pdist = length(pos.xyz);
             palpha = smoothstep(0.0, 1.0, (pdist - 0.1) / uFade.z);
             
             vec3 elrsn = sin(aEuler);
             vec3 elrcs = cos(aEuler);
             mat3 rotx = mat3(
                 1.0, 0.0, 0.0,
                 0.0, elrcs.x, elrsn.x,
                 0.0, -elrsn.x, elrcs.x
             );
             mat3 roty = mat3(
                 elrcs.y, 0.0, -elrsn.y,
                 0.0, 1.0, 0.0,
                 elrsn.y, 0.0, elrcs.y
             );
             mat3 rotz = mat3(
                 elrcs.z, elrsn.z, 0.0, 
                 -elrsn.z, elrcs.z, 0.0,
                 0.0, 0.0, 1.0
             );
             mat3 rotmat = rotx * roty * rotz;
             normal = rotmat[2];
             
             mat3 trrotm = mat3(
                 rotmat[0][0], rotmat[1][0], rotmat[2][0],
                 rotmat[0][1], rotmat[1][1], rotmat[2][1],
                 rotmat[0][2], rotmat[1][2], rotmat[2][2]
             );
             normX = trrotm[0];
             normY = trrotm[1];
             normZ = trrotm[2];
             
             const vec3 lit = vec3(0.6917144638660746, 0.6917144638660746, -0.20751433915982237);
             
             float tmpdfs = dot(lit, normal);
             if(tmpdfs < 0.0) {
                 normal = -normal;
                 tmpdfs = dot(lit, normal);
             }
             diffuse = 0.4 + tmpdfs;
             
             vec3 eyev = normalize(-pos.xyz);
             if(dot(eyev, normal) > 0.0) {
                 vec3 hv = normalize(eyev + lit);
                 specular = pow(max(dot(hv, normal), 0.0), 20.0);
             }
             else {
                 specular = 0.0;
             }
             
             rstop = clamp((abs(pdist - uDOF.x) - uDOF.y) / uDOF.z, 0.0, 1.0);
             rstop = pow(rstop, 0.5);
             //-0.69315 = ln(0.5)
             distancefade = min(1.0, exp((uFade.x - pdist) * 0.69315 / uFade.y));
         }
      </script>
      <script id="sakura_point_fsh" type="x-shader/x_fragment">
         #ifdef GL_ES
         //precision mediump float;
         precision highp float;
         #endif
         
         uniform vec3 uDOF;  //x:focus distance, y:focus radius, z:max radius
         uniform vec3 uFade; //x:start distance, y:half distance, z:near fade start
         
         const vec3 fadeCol = vec3(0.08, 0.03, 0.06);
         
         varying vec3 pposition;
         varying float psize;
         varying float palpha;
         varying float pdist;
         
         //varying mat3 rotMat;
         varying vec3 normX;
         varying vec3 normY;
         varying vec3 normZ;
         varying vec3 normal;
         
         varying float diffuse;
         varying float specular;
         varying float rstop;
         varying float distancefade;
         
         float ellipse(vec2 p, vec2 o, vec2 r) {
             vec2 lp = (p - o) / r;
             return length(lp) - 1.0;
         }
         
         void main(void) {
             vec3 p = vec3(gl_PointCoord - vec2(0.5, 0.5), 0.0) * 2.0;
             vec3 d = vec3(0.0, 0.0, -1.0);
             float nd = normZ.z; //dot(-normZ, d);
             if(abs(nd) < 0.0001) discard;
             
             float np = dot(normZ, p);
             vec3 tp = p + d * np / nd;
             vec2 coord = vec2(dot(normX, tp), dot(normY, tp));
             
             //angle = 15 degree
             const float flwrsn = 0.258819045102521;
             const float flwrcs = 0.965925826289068;
             mat2 flwrm = mat2(flwrcs, -flwrsn, flwrsn, flwrcs);
             vec2 flwrp = vec2(abs(coord.x), coord.y) * flwrm;
             
             float r;
             if(flwrp.x < 0.0) {
                 r = ellipse(flwrp, vec2(0.065, 0.024) * 0.5, vec2(0.36, 0.96) * 0.5);
             }
             else {
                 r = ellipse(flwrp, vec2(0.065, 0.024) * 0.5, vec2(0.58, 0.96) * 0.5);
             }
             
             if(r > rstop) discard;
             
             vec3 col = mix(vec3(1.0, 0.8, 0.75), vec3(1.0, 0.9, 0.87), r);
             float grady = mix(0.0, 1.0, pow(coord.y * 0.5 + 0.5, 0.35));
             col *= vec3(1.0, grady, grady);
             col *= mix(0.8, 1.0, pow(abs(coord.x), 0.3));
             col = col * diffuse + specular;
             
             col = mix(fadeCol, col, distancefade);
             
             float alpha = (rstop > 0.001)? (0.5 - r / (rstop * 2.0)) : 1.0;
             alpha = smoothstep(0.0, 1.0, alpha) * palpha;
             
             gl_FragColor = vec4(col * 0.5, alpha);
         }
      </script>
      <!-- effects -->
      <script id="fx_common_vsh" type="x-shader/x_vertex">
         uniform vec3 uResolution;
         attribute vec2 aPosition;
         
         varying vec2 texCoord;
         varying vec2 screenCoord;
         
         void main(void) {
             gl_Position = vec4(aPosition, 0.0, 1.0);
             texCoord = aPosition.xy * 0.5 + vec2(0.5, 0.5);
             screenCoord = aPosition.xy * vec2(uResolution.z, 1.0);
         }
      </script>
      <script id="bg_fsh" type="x-shader/x_fragment">
         #ifdef GL_ES
         //precision mediump float;
         precision highp float;
         #endif
         
         uniform vec2 uTimes;
         
         varying vec2 texCoord;
         varying vec2 screenCoord;
         
         void main(void) {
             vec3 col;
             float c;
             vec2 tmpv = texCoord * vec2(0.8, 1.0) - vec2(0.95, 1.0);
             c = exp(-pow(length(tmpv) * 1.8, 2.0));
             col = mix(vec3(0.02, 0.0, 0.03), vec3(0.96, 0.98, 1.0) * 1.5, c);
             gl_FragColor = vec4(col * 0.5, 1.0);
         }
      </script>
      <script id="fx_brightbuf_fsh" type="x-shader/x_fragment">
         #ifdef GL_ES
         //precision mediump float;
         precision highp float;
         #endif
         uniform sampler2D uSrc;
         uniform vec2 uDelta;
         
         varying vec2 texCoord;
         varying vec2 screenCoord;
         
         void main(void) {
             vec4 col = texture2D(uSrc, texCoord);
             gl_FragColor = vec4(col.rgb * 2.0 - vec3(0.5), 1.0);
         }
      </script>
      <script id="fx_dirblur_r4_fsh" type="x-shader/x_fragment">
         #ifdef GL_ES
         //precision mediump float;
         precision highp float;
         #endif
         uniform sampler2D uSrc;
         uniform vec2 uDelta;
         uniform vec4 uBlurDir; //dir(x, y), stride(z, w)
         
         varying vec2 texCoord;
         varying vec2 screenCoord;
         
         void main(void) {
             vec4 col = texture2D(uSrc, texCoord);
             col = col + texture2D(uSrc, texCoord + uBlurDir.xy * uDelta);
             col = col + texture2D(uSrc, texCoord - uBlurDir.xy * uDelta);
             col = col + texture2D(uSrc, texCoord + (uBlurDir.xy + uBlurDir.zw) * uDelta);
             col = col + texture2D(uSrc, texCoord - (uBlurDir.xy + uBlurDir.zw) * uDelta);
             gl_FragColor = col / 5.0;
         }
      </script>
      <!-- effect fragment shader template -->
      <script id="fx_common_fsh" type="x-shader/x_fragment">
         #ifdef GL_ES
         //precision mediump float;
         precision highp float;
         #endif
         uniform sampler2D uSrc;
         uniform vec2 uDelta;
         
         varying vec2 texCoord;
         varying vec2 screenCoord;
         
         void main(void) {
             gl_FragColor = texture2D(uSrc, texCoord);
         }
      </script>
      <!-- post processing -->
      <script id="pp_final_vsh" type="x-shader/x_vertex">
         uniform vec3 uResolution;
         attribute vec2 aPosition;
         varying vec2 texCoord;
         varying vec2 screenCoord;
         void main(void) {
             gl_Position = vec4(aPosition, 0.0, 1.0);
             texCoord = aPosition.xy * 0.5 + vec2(0.5, 0.5);
             screenCoord = aPosition.xy * vec2(uResolution.z, 1.0);
         }
      </script>
      <script id="pp_final_fsh" type="x-shader/x_fragment">
         #ifdef GL_ES
         //precision mediump float;
         precision highp float;
         #endif
         uniform sampler2D uSrc;
         uniform sampler2D uBloom;
         uniform vec2 uDelta;
         varying vec2 texCoord;
         varying vec2 screenCoord;
         void main(void) {
             vec4 srccol = texture2D(uSrc, texCoord) * 2.0;
             vec4 bloomcol = texture2D(uBloom, texCoord);
             vec4 col;
             col = srccol + bloomcol * (vec4(1.0) + srccol);
             col *= smoothstep(1.0, 0.0, pow(length((texCoord - vec2(0.5)) * 2.0), 1.2) * 0.5);
             col = pow(col, vec4(0.45454545454545)); //(1.0 / 2.2)
             
             gl_FragColor = vec4(col.rgb, 1.0);
             gl_FragColor.a = 1.0;
         }
      </script>
      <script src="https://looming.w3codemasters.in/js/onload.js"></script>
      <script>$(window).load(function () { $('.load').fadeOut(700); });</script>
      <script src="https://looming.w3codemasters.in/js/animation.js"></script>
      <script src="https://looming.w3codemasters.in/js/jquery.min.js"></script>
      <script src="https://looming.w3codemasters.in/js/wow.min.js"></script>
      <!-- config date -->
      <script src="<?php echo site_url()."assets/under_construction/custom.js";?>"></script>
      <!-- end config date -->
   </body>
</html>