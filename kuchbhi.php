
<!-- This code was generated using AnimaApp.com. 
This code is a high-fidelity prototype.
Get developer-friendly React or HTML/CSS code for this project at: https://projects.animaapp.com?utm_source=hosted-code 
21/08/2024 05:01:17 -->

<html><head><meta charset="utf-8"><meta name="viewport" content="width=1440, maximum-scale=1.0"><link rel="shortcut icon" type="image/png" href="https://animaproject.s3.amazonaws.com/home/favicon.png"><meta name="og:type" content="website"><meta name="twitter:card" content="photo"><script id="anima-load-script" src="load.js"></script><script id="anima-hotspots-script" src="hotspots.js"></script><script id="anima-overrides-script" src="overrides.js"></script><script src="https://animaapp.s3.amazonaws.com/js/timeline.js"></script><style>
@import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");

@import url("https://fonts.googleapis.com/css?family=Poppins:300,400,600,500|Inter:500");

/* The following line is used to measure usage of this code. You can remove it if you want. */
@import url("https://px.animaapp.com/66c57389f73bcbab6fed759f.66c5738af73bcbab6fed75a2.RJtNMmt.hch.png");


.screen textarea:focus,
.screen input:focus {
  outline: none;
}

.screen * {
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}

.screen div {
  -webkit-text-size-adjust: none;
}

.component-wrapper a {
  display: contents;
  pointer-events: auto;
  text-decoration: none;
}

.component-wrapper * {
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
  pointer-events: none;
}

.component-wrapper a *,
.component-wrapper input,
.component-wrapper video,
.component-wrapper iframe {
  pointer-events: auto;
}

.component-wrapper.not-ready,
.component-wrapper.not-ready * {
  visibility: hidden !important;
}

.screen a {
  display: contents;
  text-decoration: none;
}

.full-width-a {
  width: 100%;
}

.full-height-a {
  height: 100%;
}

.container-center-vertical {
  align-items: center;
  display: flex;
  flex-direction: row;
  height: 100%;
  pointer-events: none;
}

.container-center-vertical > * {
  flex-shrink: 0;
  pointer-events: auto;
}

.container-center-horizontal {
  display: flex;
  flex-direction: row;
  justify-content: center;
  pointer-events: none;
  width: 100%;
}

.container-center-horizontal > * {
  flex-shrink: 0;
  pointer-events: auto;
}

.auto-animated div {
  --z-index: -1;
  opacity: 0;
  position: absolute;
}

.auto-animated input {
  --z-index: -1;
  opacity: 0;
  position: absolute;
}

.auto-animated .container-center-vertical,
.auto-animated .container-center-horizontal {
  opacity: 1;
}

.overlay-base {
  display: none;
  height: 100%;
  opacity: 0;
  position: fixed;
  top: 0;
  width: 100%;
}

.overlay-base.animate-appear {
  align-items: center;
  animation: reveal 0.3s ease-in-out 1 normal forwards;
  display: flex;
  flex-direction: column;
  justify-content: center;
  opacity: 0;
}

.overlay-base.animate-disappear {
  animation: reveal 0.3s ease-in-out 1 reverse forwards;
  display: block;
  opacity: 1;
  pointer-events: none;
}

.overlay-base.animate-disappear * {
  pointer-events: none;
}

@keyframes reveal {
  from { opacity: 0 }
 to { opacity: 1 }
}

.animate-nodelay {
  animation-delay: 0s;
}

.align-self-flex-start {
  align-self: flex-start;
}

.align-self-flex-end {
  align-self: flex-end;
}

.align-self-flex-center {
  align-self: flex-center;
}

.valign-text-middle {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.valign-text-bottom {
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
}

input:focus {
  outline: none;
}

.listeners-active,
.listeners-active * {
  pointer-events: auto;
}

.hidden,
.hidden * {
  pointer-events: none;
  visibility: hidden;
}

.smart-layers-pointers,
.smart-layers-pointers * {
  pointer-events: auto;
  visibility: visible;
}

.listeners-active-click,
.listeners-active-click * {
  cursor: pointer;
}

* {
  box-sizing: border-box;
}
:root { 
  --black: #000000;
  --chalet-green: #4a6437;
  --chalet-green-2: #4a643780;
  --mummys-tomb: #868f7f;
  --sage: #9ea995;
  --sugar-cane: #f8fff3;
  --westar: #d7ded4;
  --white: #ffffff;
  --white-2: #ffffffb2;
 
  --font-size-l: 16.3px;
  --font-size-m: 16px;
  --font-size-s: 15px;
  --font-size-xl: 18px;
  --font-size-xs: 13.6px;
  --font-size-xxl: 18.1px;
  --font-size-xxxl: 19.6px;
 
  --font-family-poppins: "Poppins", Helvetica;
}
.poppins-medium-chalet-green-16px {
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-m);
  font-style: normal;
  font-weight: 500;
}

.poppins-light-chalet-green-18-1px {
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-xxl);
  font-style: normal;
  font-weight: 300;
}

.poppins-medium-white-16px {
  color: var(--white);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-m);
  font-style: normal;
  font-weight: 500;
}

.poppins-light-white-15px {
  color: var(--white-2);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-s);
  font-style: normal;
  font-weight: 300;
}

.poppins-light-white-16px {
  color: var(--white);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-m);
  font-style: normal;
  font-weight: 300;
}

.poppins-medium-chalet-green-23-8px {
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 23.8px;
  font-style: normal;
  font-weight: 500;
}

.poppins-medium-black-16px {
  color: var(--black);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-m);
  font-style: normal;
  font-weight: 500;
}

.poppins-normal-chalet-green-18px {
  color: var(--chalet-green-2);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-xl);
  font-style: normal;
  font-weight: 400;
}

.poppins-light-mummys-tomb-16-3px {
  color: var(--mummys-tomb);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-l);
  font-style: normal;
  font-weight: 300;
}

.poppins-normal-white-16px {
  color: var(--white);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-m);
  font-style: normal;
  font-weight: 400;
}

.poppins-normal-westar-16px {
  color: var(--westar);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-m);
  font-style: normal;
  font-weight: 400;
}

.poppins-medium-chalet-green-13px {
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 13px;
  font-style: normal;
  font-weight: 500;
}

.poppins-normal-chalet-green-17-3px {
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 17.3px;
  font-style: normal;
  font-weight: 400;
}

.poppins-normal-sugar-cane-23-1px {
  color: var(--sugar-cane);
  font-family: var(--font-family-poppins);
  font-size: 23.1px;
  font-style: normal;
  font-weight: 400;
}

.poppins-medium-chalet-green-17-1px {
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 17.1px;
  font-style: normal;
  font-weight: 500;
}

.poppins-light-sage-13-6px {
  color: var(--sage);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-xs);
  font-style: normal;
  font-weight: 300;
}

.poppins-medium-chalet-green-13-2px {
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 13.2px;
  font-style: normal;
  font-weight: 500;
}

.poppins-normal-chalet-green-18-1px {
  color: var(--chalet-green-2);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-xxl);
  font-style: normal;
  font-weight: 400;
}

:root {
}


.follow-us {
  background-color: transparent;
  left: 0px;
  position: absolute;
  top: 0px;
}

.vector-3 {
  background-color: transparent;
  position: absolute;
}

.x100-purchase-protection-T7vxb0 {
  background-color: transparent;
  height: auto;
  left: 51px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: left;
  top: 0px;
  width: auto;
}

.group-T7vxb0 {
  height: 28px;
  left: 0px;
  top: 0px;
  width: 30px;
}

.add-to-cart-zif1O8 {
  margin-bottom: -3.89px;
  margin-left: -5.57px;
  margin-top: -5.14px;
}

.component-1-zif1O8 {
  height: 21.586591720581055px;
  margin-right: -5.57px;
  width: 21.586591720581055px;
}

.ellipse-2-aXAqDC {
  border: 0.5301825404167175px solid;
  border-color: var(--white);
  border-radius: 11.32px;
  height: 23px;
  left: -1px;
  top: -1px;
  width: 23px;
}

.vector-3-aXAqDC {
  height: 8px;
  left: 9px;
  top: 7px;
  width: 4px;
}

.add-to-cart {
  background-color: transparent;
  letter-spacing: 0.00px;
  line-height: normal;
  position: relative;
  text-align: left;
  width: fit-content;
}

.component-1 {
  background-color: transparent;
  position: relative;
}

.ellipse-2 {
  background-color: transparent;
  position: absolute;
}

.frame-11 {
  align-items: center;
  display: flex;
  justify-content: center;
  position: absolute;
}

.group {
  background-color: transparent;
  position: absolute;
}

.next-button-1-B08mCn {
  background-color: transparent;
  height: 8px;
  left: 41px;
  object-fit: cover;
  position: absolute;
  top: 6px;
  width: 8px;
}

.next-button-2-B08mCn {
  background-color: transparent;
  height: 8px;
  left: 149px;
  object-fit: cover;
  position: absolute;
  top: 6px;
  width: 8px;
}

.group-107 {
  background-color: transparent;
  height: 64px;
  left: 0px;
  position: absolute;
  top: 0px;
  width: 260px;
}

.group-93 {
  background-color: transparent;
  height: 19px;
  left: 98px;
  position: absolute;
  top: 0px;
  width: 21px;
}

.group-94 {
  background-color: transparent;
  height: 19px;
  left: 0px;
  position: absolute;
  top: 0px;
  width: 21px;
}

.group-95 {
  background-color: transparent;
  height: 20px;
  left: 37px;
  position: absolute;
  top: 0px;
  width: 45px;
}

.rectangle-93 {
  background-color: transparent;
  border: 0.6146404147148132px solid;
  border-color: var(--chalet-green);
  height: 20px;
  left: -1px;
  position: absolute;
  top: -1px;
  width: 20px;
}

.rectangle-94 {
  background-color: transparent;
  border: 0.6146404147148132px solid;
  border-color: var(--chalet-green);
  height: 20px;
  left: -1px;
  position: absolute;
  top: -1px;
  width: 44px;
}

.rectangle-95 {
  background-color: transparent;
  border: 0.6146404147148132px solid;
  border-color: var(--chalet-green);
  height: 20px;
  left: -1px;
  position: absolute;
  top: -1px;
  width: 20px;
}

.x1 {
  background-color: transparent;
  height: auto;
  left: 18px;
  letter-spacing: 0.00px;
  line-height: 18.4px;
  position: absolute;
  text-align: left;
  top: 1px;
  white-space: nowrap;
  width: auto;
}

.care-3U5qE3 {
  --z-index: 0;
  background-color: transparent;
  color: #4a6437;
  font-family: 'Poppins', Helvetica;
  font-size: 18.1px;
  font-style: normal;
  font-weight: 300;
  height: 24px;
  left: 0px;
  letter-spacing: 0.00px;
  line-height: normal;
  opacity: 1;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 44px;
}

.men-3U5qE3 {
  --z-index: 1;
  background-color: transparent;
  color: #4a6437;
  font-family: 'Poppins', Helvetica;
  font-size: 18.1px;
  font-style: normal;
  font-weight: 300;
  height: 24px;
  left: 62px;
  letter-spacing: 0.00px;
  line-height: normal;
  opacity: 1;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 38px;
}

.women-3U5qE3 {
  --z-index: 2;
  background-color: transparent;
  color: #4a6437;
  font-family: 'Poppins', Helvetica;
  font-size: 18.1px;
  font-style: normal;
  font-weight: 300;
  height: 24px;
  left: 118px;
  letter-spacing: 0.00px;
  line-height: normal;
  opacity: 1;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 71px;
}

.products-3U5qE3 {
  --z-index: 3;
  background-color: transparent;
  color: #4a6437;
  font-family: 'Poppins', Helvetica;
  font-size: 18.1px;
  font-style: normal;
  font-weight: 300;
  height: 24px;
  left: 205px;
  letter-spacing: 0.00px;
  line-height: normal;
  opacity: 1;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 80px;
}
/* screen - product-delivery */

.product-delivery {
  background-color: var(--white);
  height: 1397px;
  overflow: hidden;
  overflow-x: hidden;
  position: relative;
  width: 1440px;
}

.product-delivery .rectangle-97-C61RwL {
  background-color: var(--sugar-cane);
  height: 1638px;
  left: 0px;
  position: absolute;
  top: 2px;
  width: 1440px;
}

.product-delivery .lorem-ipsumis-simply-C61RwL {
  background-color: transparent;
  color: var(--black);
  font-family: var(--font-family-poppins);
  font-size: var(--font-size-xxxl);
  font-style: normal;
  font-weight: 300;
  height: 29px;
  left: 403px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 446px;
  width: auto;
}

.product-delivery .title-C61RwL {
  background-color: transparent;
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 30.1px;
  font-style: normal;
  font-weight: 500;
  height: 45px;
  left: 572px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 396px;
  width: auto;
}

.product-delivery .group-98-C61RwL {
  background-color: transparent;
  height: 54px;
  left: 28px;
  position: absolute;
  top: 32px;
  width: 1382px;
}

.product-delivery .asset-23x-1-royatl {
  background-color: transparent;
  height: 54px;
  left: 592px;
  object-fit: cover;
  position: absolute;
  top: 0px;
  width: 200px;
}

.product-delivery .group-96-royatl {
  background-color: transparent;
  height: 24px;
  left: 0px;
  position: absolute;
  top: 16px;
  width: 293px;
}

.product-delivery .care-OxmyQz {
  background-color: transparent;
  height: 24px;
  left: 0px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 44px;
}

.product-delivery .men-OxmyQz {
  background-color: transparent;
  height: 24px;
  left: 62px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 38px;
}

.product-delivery .women-OxmyQz {
  background-color: transparent;
  height: 24px;
  left: 118px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 71px;
}

.product-delivery .products-OxmyQz {
  background-color: transparent;
  height: 24px;
  left: 205px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 0px;
  width: 80px;
}

.product-delivery .group-97-royatl {
  background-color: transparent;
  height: 30px;
  left: 1264px;
  position: absolute;
  top: 13px;
  width: 118px;
}

.product-delivery .footer-C61RwL {
  top: 854px;
}

.product-delivery .footer-iPe1yZ {
  top: 0px;
}

.product-delivery .rectangle-83-qJOyZt {
  background-color: var(--chalet-green);
  height: 543px;
  left: 0px;
  position: absolute;
  top: 0px;
  width: 1440px;
}

.product-delivery .group-74-qJOyZt {
  background-color: transparent;
  height: 222px;
  left: 77px;
  position: absolute;
  top: 159px;
  width: 261px;
}

.product-delivery .lorem-ipsumis-simply-dummy-text-UYrr6o {
  background-color: transparent;
  height: auto;
  left: 0px;
  letter-spacing: 0.00px;
  line-height: 20.4px;
  position: absolute;
  text-align: center;
  top: 179px;
  width: 259px;
}

.product-delivery .group-72-UYrr6o {
  background-color: transparent;
  height: 222px;
  left: 0px;
  position: absolute;
  top: 0px;
  width: 261px;
}

.product-delivery .group-71-KF2H2t {
  background-color: transparent;
  height: 154px;
  left: 27px;
  position: absolute;
  top: 0px;
  width: 204px;
}

.product-delivery .simply-dummy-text-KF2H2t {
  background-color: transparent;
  height: auto;
  left: 0px;
  letter-spacing: 0.00px;
  line-height: 20.4px;
  position: absolute;
  text-align: center;
  top: 202px;
  width: 259px;
}

.product-delivery .group-73-qJOyZt {
  background-color: transparent;
  height: 366px;
  left: 626px;
  position: absolute;
  top: 87px;
  width: 197px;
}

.product-delivery .track-your-order-about-us-contact-us-faq-R27Voy {
  background-color: transparent;
  height: auto;
  left: 0px;
  letter-spacing: 2.40px;
  line-height: 24.1px;
  position: absolute;
  text-align: left;
  top: 35px;
  width: auto;
}

.product-delivery .care-skincare-facewash-serum-R27Voy {
  background-color: transparent;
  height: auto;
  left: 0px;
  letter-spacing: 2.40px;
  line-height: 24.1px;
  position: absolute;
  text-align: left;
  top: 270px;
  width: auto;
}

.product-delivery .important-links-R27Voy {
  background-color: transparent;
  height: auto;
  left: 8px;
  letter-spacing: 2.40px;
  line-height: 24.1px;
  position: absolute;
  text-align: left;
  top: 0px;
  white-space: nowrap;
  width: auto;
}

.product-delivery .category-R27Voy {
  background-color: transparent;
  height: auto;
  left: 8px;
  letter-spacing: 2.40px;
  line-height: 24.1px;
  position: absolute;
  text-align: left;
  top: 235px;
  white-space: nowrap;
  width: auto;
}

.product-delivery .group-90-qJOyZt {
  background-color: transparent;
  height: 351px;
  left: 1097px;
  position: absolute;
  top: 87px;
  width: 265px;
}

.product-delivery .follow-us-FENDMU {
  height: 81px;
  width: 150px;
}

.product-delivery .follow-us-Nx0sTU {
  height: auto;
  letter-spacing: 2.40px;
  line-height: 21.8px;
  text-align: center;
  white-space: nowrap;
  width: auto;
}

.product-delivery .group-Nx0sTU {
  background-color: transparent;
  height: 36px;
  left: 112px;
  position: absolute;
  top: 45px;
  width: 36px;
}

.product-delivery .vector-Nx0sTU {
  left: 1px;
}

.product-delivery .vector-BZe2HZ {
  left: 57px;
}

.product-delivery .frame-42-FENDMU {
  align-items: flex-start;
  background-color: transparent;
  display: flex;
  flex-direction: column;
  gap: 23px;
  left: 1px;
  position: absolute;
  top: 233px;
  width: 264px;
}

.product-delivery .subscribe-UUYzRl {
  align-self: stretch;
  background-color: transparent;
  letter-spacing: 2.40px;
  line-height: 24.1px;
  margin-top: -1.00px;
  position: relative;
  text-align: left;
}

.product-delivery .component-8-UUYzRl {
  background-color: transparent;
  height: 25.8876953125px;
  position: relative;
  width: 264.125px;
}

.product-delivery .email-id-rSfcP5 {
  background-color: transparent;
  height: auto;
  left: 0px;
  letter-spacing: -0.08px;
  line-height: 24.1px;
  opacity: 0.3;
  position: absolute;
  text-align: left;
  top: -1px;
  white-space: nowrap;
  width: auto;
}

.product-delivery .vector-5-rSfcP5 {
  background-color: transparent;
  height: 1px;
  left: 1px;
  object-fit: cover;
  position: absolute;
  top: 25px;
  width: 263px;
}

.product-delivery .vector-3-rSfcP5 {
  height: 10px;
  left: 70px;
  top: 8px;
  width: 5px;
}

.product-delivery .frame-11-FENDMU {
  align-items: center;
  background-color: var(--white);
  border-radius: 3.45px;
  display: flex;
  gap: 6.216381072998047px;
  height: 22px;
  justify-content: center;
  left: 2px;
  padding: 5.525671482086182px 11.396697998046875px;
  position: absolute;
  top: 329px;
  width: 78px;
}

.product-delivery .add-to-cart-K62COG {
  background-color: transparent;
  letter-spacing: 0.00px;
  line-height: normal;
  margin-bottom: -4.33px;
  margin-left: -4.77px;
  margin-top: -5.02px;
  position: relative;
  text-align: left;
  width: fit-content;
}

.product-delivery .component-1-K62COG {
  background-color: transparent;
  height: 11.914056777954102px;
  margin-bottom: -0.63px;
  margin-right: -4.77px;
  margin-top: -0.63px;
  position: relative;
  width: 11.914056777954102px;
}

.product-delivery .ellipse-2-uedAat {
  background-color: transparent;
  border: 0.2926179766654968px solid;
  border-color: var(--chalet-green);
  border-radius: 6.25px;
  height: 12px;
  left: -0px;
  position: absolute;
  top: -0px;
  width: 12px;
}

.product-delivery .vector-3-uedAat {
  height: 4px;
  left: 5px;
  top: 4px;
  width: 2px;
}

.product-delivery .footer-01-iPe1yZ {
  background-color: transparent;
  height: 538px;
  left: 0px;
  position: absolute;
  top: 2px;
  width: 1440px;
}

.product-delivery .group-128-default-C61RwL {
  background-color: transparent;
  height: 96px;
  left: 672px;
  position: absolute;
  top: 272px;
  width: 96px;
}

.product-delivery .ellipse-11-0HzKox {
  background-color: #dae5d3;
  border-radius: 48px;
  height: 96px;
  left: 0px;
  position: absolute;
  top: 0px;
  width: 96px;
}

.product-delivery .ellipse-12-0HzKox {
  border-radius: 38.67px;
  height: 77px;
  left: 9px;
  top: 9px;
  width: 77px;
}

.product-delivery .frame-0HzKox {
  background-color: transparent;
  height: 38px;
  left: 22px;
  position: absolute;
  top: 29px;
  width: 52px;
}

.product-delivery .group-128-C61RwL {
  background-color: transparent;
  height: 15px;
  left: 285px;
  position: absolute;
  top: 558px;
  width: 15px;
}

.product-delivery .ellipse-13-C61RwL {
  background-color: #b4b4b4;
  border-radius: 5.98px;
  height: 12px;
  left: 1179px;
  position: absolute;
  top: 559px;
  width: 12px;
}

.product-delivery .vector-14-C61RwL {
  background-color: transparent;
  height: 1px;
  left: 286px;
  position: absolute;
  top: 565px;
  width: 868px;
}

.product-delivery .vector-15-C61RwL {
  background-color: transparent;
  height: 1px;
  left: 741px;
  position: absolute;
  top: 565px;
  width: 451px;
}

.product-delivery .ellipse-12-C61RwL {
  border-radius: 5.98px;
  height: 12px;
  left: 728px;
  top: 559px;
  width: 12px;
}

.product-delivery .order-received-C61RwL {
  background-color: transparent;
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 20.1px;
  font-style: normal;
  font-weight: 300;
  height: 30px;
  left: 215px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 582px;
  width: auto;
}

.product-delivery .shipping-process-C61RwL {
  background-color: transparent;
  color: var(--chalet-green);
  font-family: var(--font-family-poppins);
  font-size: 20.1px;
  font-style: normal;
  font-weight: 300;
  height: 30px;
  left: 649px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 582px;
  width: auto;
}

.product-delivery .delivery-C61RwL {
  background-color: transparent;
  color: #b4b4b4;
  font-family: var(--font-family-poppins);
  font-size: 20.1px;
  font-style: normal;
  font-weight: 300;
  height: 30px;
  left: 1147px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: center;
  top: 582px;
  width: auto;
}

.product-delivery .group-131-C61RwL {
  background-color: transparent;
  height: 25px;
  left: 1203px;
  position: absolute;
  top: 802px;
  width: 159px;
}

.product-delivery .go-to-home-page-Ki0one {
  background-color: transparent;
  color: #666666;
  font-family: var(--font-family-poppins);
  font-size: 16.4px;
  font-style: normal;
  font-weight: 400;
  height: 25px;
  left: 0px;
  letter-spacing: 0.00px;
  line-height: normal;
  position: absolute;
  text-align: left;
  top: -1px;
  width: auto;
}

.product-delivery .vector-3-Ki0one {
  height: 12px;
  left: 153px;
  top: 6px;
  width: 6px;
}

.product-delivery .ellipse-12 {
  background-color: var(--chalet-green);
  position: absolute;
}

.product-delivery .footer {
  background-color: transparent;
  height: 543px;
  left: 0px;
  position: absolute;
  width: 1440px;
}

.product-delivery .vector {
  background-color: transparent;
  height: 36px;
  position: absolute;
  top: 45px;
  width: 36px;
}
</style>
</head>
    <body style="margin: 0;background: #ffffff;">
            <input type="hidden" id="anPageName" name="page" value="product-delivery">
                <div class="container-center-horizontal">
                    <div class="product-delivery screen " data-id="524:466">
                        <div class="rectangle-97-C61RwL" data-id="524:467"></div>
                            <p class="lorem-ipsumis-simply-C61RwL valign-text-middle" data-id="535:584">Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                            <h1 class="title-C61RwL valign-text-middle" data-id="535:583">Thank you for order</h1>
                            <div class="group-98-C61RwL" data-id="524:468">
                                <img class="asset-23x-1-royatl" data-id="524:469" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="" alt="Asset 2@3x 1">
                                <div class="group-96-royatl" data-id="524:470">
                                    <div class="care-OxmyQz valign-text-middle poppins-light-chalet-green-18-1px" data-id="524:471">Care</div>
                                    <div class="men-OxmyQz valign-text-middle poppins-light-chalet-green-18-1px" data-id="524:472">Men</div>
                                    <div class="women-OxmyQz valign-text-middle poppins-light-chalet-green-18-1px" data-id="524:473">Women</div>
                                    <div class="products-OxmyQz valign-text-middle poppins-light-chalet-green-18-1px" data-id="524:474">Products</div>
                                </div>
                                <img class="group-97-royatl" data-id="524:475" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/group-97-1@2x.png" alt="Group 97">
                                </div>
                                <div class="footer-C61RwL footer" data-id="532:487">
                                    <div class="footer-iPe1yZ footer" data-id="532:488">
                                        <div class="rectangle-83-qJOyZt" data-id="532:489"></div>
                                        <div class="group-74-qJOyZt" data-id="532:490">
                                            <p class="lorem-ipsumis-simply-dummy-text-UYrr6o poppins-light-white-15px" data-id="532:491">Lorem Ipsum is simply dummy text</p>
                                            <div class="group-72-UYrr6o" data-id="532:492">
                                                <img class="group-71-KF2H2t" data-id="532:493" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/group-71@2x.png" alt="Group 71">
                                                    <div class="simply-dummy-text-KF2H2t poppins-light-white-15px" data-id="532:500">simply dummy text</div>
                                            </div>
                                        </div>
                                        <div class="group-73-qJOyZt" data-id="532:501">
                                            <p class="track-your-order-about-us-contact-us-faq-R27Voy poppins-light-white-16px" data-id="532:502">Track your order<br>About Us<br>Contact Us<br>FAQ</p><div class="care-skincare-facewash-serum-R27Voy poppins-light-white-16px" data-id="532:503">Care<br>Skincare<br>Facewash<br>Serum</div><div class="important-links-R27Voy poppins-medium-white-16px" data-id="532:504">Important Links</div><div class="category-R27Voy poppins-medium-white-16px" data-id="532:505">Category</div></div><div class="group-90-qJOyZt" data-id="532:506"><div class="follow-us-FENDMU follow-us" data-id="532:507"><div class="follow-us-Nx0sTU follow-us poppins-medium-white-16px" data-id="532:508">Follow Us</div><img class="group-Nx0sTU" data-id="532:509" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/group-1@2x.png" alt="Group"><img class="vector-Nx0sTU vector" data-id="532:514" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-3.svg" alt="Vector"><img class="vector-BZe2HZ vector" data-id="532:515" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-4.svg" alt="Vector"></div><div class="frame-42-FENDMU" data-id="532:516"><div class="subscribe-UUYzRl poppins-normal-white-16px" data-id="532:517">Subscribe</div><div class="component-8-UUYzRl" data-id="532:518"><div class="email-id-rSfcP5 poppins-normal-westar-16px" data-id="I532:518;281:716">Email ID</div><img class="vector-5-rSfcP5" data-id="I532:518;281:717" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-5.svg" alt="Vector 5"><img class="vector-3-rSfcP5 vector-3" data-id="I532:518;281:718" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-3-1.svg" alt="Vector 3"></div></div><div class="frame-11-FENDMU" data-id="532:520"><div class="add-to-cart-K62COG poppins-medium-chalet-green-13px" data-id="I532:520;101:95">Submit</div><div class="component-1-K62COG" data-id="I532:520;101:96"><div class="ellipse-2-uedAat" data-id="I532:520;101:97"></div><img class="vector-3-uedAat vector-3" data-id="I532:520;101:98" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-3-2.svg" alt="Vector 3"></div></div></div></div><img class="footer-01-iPe1yZ" data-id="937:3984" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/footer-01.png" alt="footer 01"></div><div class="group-128-default-C61RwL" data-id="535:577"><div class="ellipse-11-0HzKox" data-id="535:578"></div><div class="ellipse-12-0HzKox ellipse-12" data-id="535:579"></div><img class="frame-0HzKox" data-id="535:580" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/frame-2.svg" alt="Frame"></div><img class="group-128-C61RwL" data-id="540:590" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/group-128.svg" alt="Group 128"><div class="ellipse-13-C61RwL" data-id="540:597"></div><img class="vector-14-C61RwL" data-id="540:600" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-14.svg" alt="Vector 14"><img class="vector-15-C61RwL" data-id="546:619" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-15.svg" alt="Vector 15"><div class="ellipse-12-C61RwL ellipse-12" data-id="540:596"></div><div class="order-received-C61RwL valign-text-middle" data-id="546:622">Order Received</div><div class="shipping-process-C61RwL valign-text-middle" data-id="546:623">Shipping Process</div><div class="delivery-C61RwL valign-text-middle" data-id="546:624">Delivery</div><div class="group-131-C61RwL" data-id="546:643"><div class="go-to-home-page-Ki0one valign-text-middle" data-id="I546:643;546:629">Go to home page</div><img class="vector-3-Ki0one vector-3" data-id="I546:643;546:635" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" anima-src="https://cdn.animaapp.com/projects/66c573d1111b4884eebf3a26/releases/66c5749763b928c601edeafc/img/vector-3-3.svg" alt="Vector 3"></div></div></div><script src="launchpad-js/launchpad-banner.js" async></script><script defer src="https://animaapp.s3.amazonaws.com/static/restart-btn.min.js"></script></body></html>
<!-- This code was generated using AnimaApp.com. 
This code is a high-fidelity prototype.
Get developer-friendly React or HTML/CSS code for this project at: https://projects.animaapp.com?utm_source=hosted-code 
21/08/2024 05:01:17 -->

