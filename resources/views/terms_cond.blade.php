@extends('common.default')
@section('content')
<style>
   .has-error .form-control {
   border-color: #a94442;
   -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
   box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
   }
   p{
    font-family:'Lato', sans-serif !important;
    font-weight:300;
    font-size:14px;
    line-height:1.4;
    text-align: justify;
   }
   h4,h5{
    font-weight: 600;
   }
   h5{
    font-size: 16px;
   }
</style>

{!! Form::open(array('method'=>'POST','url'=>'terms_cond','class'=>'form-horizontal',"style"=>"margin:0em !important", "id"=>"register-form")) !!}
    <div class="container" >
        <div class="row">
          <div class="col-xs-12">
          {!! $content !!}
            {{-- Copy from below --}}{{-- 
              <h2 style="text-align:center;">Terms & Condition</h2>
                <h4>Introduction</h4>
                <p>Welcome to the <b> OpenSupermall.com website</b> (the "Site"). These terms and conditions ("Terms and Conditions") apply to the Site, <b>Intermedius OpenSupermall Sdn Bhd</b> , and all of its divisions, subsidiaries, and affiliate operated Internet sites which reference these Terms and Conditions.
                    By accessing the Site, you confirm your understanding of the Terms and Conditions. If you do not agree to these Terms and Conditions of use, you shall not use this website. The Site reserves the right, to change, modify, add, or remove portions of these Terms and Conditions of use at any time. Changes will be effective when posted on the Site with no other notice provided. Please check these Terms and Conditions of use regularly for updates. Your continued use of the Site following the posting of changes to these Terms and Conditions of use constitutes your acceptance of those changes.</p>
                <h4>Use of Site</h4>
                <p>
                   We grant you a non-transferable and revocable license to use the Site, under the Terms and Conditions described, for the purpose of shopping for personal items sold on the Site. Commercial use or use on behalf of any third party is prohibited, except as explicitly permitted by us in advance. Any breach of these Terms and Conditions shall result in the immediate revocation of the license granted in this paragraph without notice to you.
                    Content provided on this site is solely for informational purposes. Product representations expressed on this Site are those of the vendor and are not made by us. Submissions or opinions expressed on this Site are those of the individual posting such content and may not reflect our opinions.
                    Certain services and related features that may be made available on the Site may require registration or subscription. Should you choose to register or subscribe for any such services or related features, you agree to provide accurate and current information about yourself, and to promptly update such information if there are any changes. Every user of the Site is solely responsible for keeping passwords and other account identifiers safe and secure. The account owner is entirely responsible for all activities that occur under such password or account. Furthermore, you must notify us of any unauthorized use of your password or account. The Site shall not be responsible or liable, directly or indirectly, in any way for any loss or damage of any kind incurred as a result of, or in connection with, your failure to comply with this section.
                </p>
                <h4>User Submissions</h4>
                <p>
                    Anything that you submit to the Site and/or provide to us, including but not limited to, questions, reviews, comments, and suggestions (collectively, "Submissions") will become our sole and exclusive property and shall not be returned to you. In addition to the rights applicable to any Submission, when you post comments or reviews to the Site, you also grant us the right to use the name that you submit, in connection with such review, comment, or other content. You shall not use a false e-mail address, pretend to be someone other than yourself or otherwise mislead us or third parties as to the origin of any Submissions. We may, but shall not be obligated to, remove or edit any Submissions.
                </p>
                <h4>Order Acceptance & Pricing</h4>
                <p>
                     Please note that there are cases when an order cannot be processed for various reasons. The Site reserves the right to refuse or cancel any order for any reason at any given time. You may be asked to provide additional verifications or information, including but not limited to phone number and address, before we accept the order.
                    We are determined to provide the most accurate pricing information on the Site to our users; however, errors may still occur, such as cases when the price of an item is not displayed correctly on the website. As such, we reserve the right to refuse or cancel any order. In the event that an item is mispriced, we may, at our own discretion, either contact you for instructions or cancel your order and notify you of such cancellation. We shall have the right to refuse or cancel any such orders whether or not the order has been confirmed and your credit card or bank account charged.
                </p>
                <h4>GST</h4>
                <p>
                   GST will be implemented in Malaysia with effect from <b>1 April 2015 at the rate of 6% </b>. It will replace the existing sales tax and service tax. Prices of Items and services provided by Intermedius Open Supermall Sdn Bhd, being GST registered company, will include GST where applicable.
                    Please refer to the <b>GST Act 2014</b> published in the gazette on <b>19 June 2014 and the GST Regulations 2014 issued on 30 June 2014</b>. GST is under the jurisdiction of the <b>Royal Malaysian Customs Department</b> (“Customs Department”).
                </p>
                <h4>Trademarks & Copyrights</h4>

                 <p>All intellectual property rights, whether registered or unregistered, in the Site, information content on the Site and all the website design, including, but not limited to, text, graphics, software, photos, video, music, sound, and their selection and arrangement, and all software compilations, underlying source code and software shall remain our property. The entire contents of the Site also are protected by copyright as a collective work under Malaysia copyright laws and international conventions. All rights are reserved.</p>
                  <h4>Applicable law & Juridiction</h4>
                  <p>
                    These Terms and Conditions shall be interpreted and governed by the laws in force in Malaysia. Subject to the Arbitration section below, each party hereby agrees to submit to the jurisdiction of the courts of Government of Malaysia to waive any objections based upon venue.
                    </p>
                    <h4>Arbitration</h4>
                    <p>Any controversy, claim or dispute arising out of or relating to these Terms and Conditions will be referred to and finally settled by private and confidential binding arbitration before a single arbitrator held in Malaysia in English and governed by Malaysian law. The arbitrator shall be a person who is legally trained and who has experience in the information technology field in Malaysia and is independent of either party. Notwithstanding the foregoing, the Site reserves the right to pursue the protection of intellectual property rights and confidential information through injunctive or other equitable relief through the courts.</p>
                    <h4>Termination</h4>
                    <p>In addition to any other legal or equitable remedies, we may, without prior notice to you, immediately terminate the Terms and Conditions or revoke any or all of your rights granted under the Terms and Conditions. Upon any termination of this Agreement, you shall immediately cease all access to and use of the Site and we shall, in addition to any other legal or equitable remedies, immediately revoke all password(s) and account identification issued to you and deny your access to and use of this Site in whole or in part. Any termination of this agreement shall not affect the respective rights and obligations (including without limitation, payment obligations) of the parties arising before the date of termination. You furthermore agree that the Site shall not be liable to you or to any other person as a result of any such suspension or termination. </p>
                    <h4>Terms of Use</h4>

                    <h5>1. Interpretation</h5>
                      <p><strong>1.1</strong> In these Conditions:
                    "Buyer" means the person who accepts a quotation of OpenSupermall for the supply of Goods or who otherwise enters into a contract for the supply of Goods with OpenSupermall ;
                    "Conditions" mean the general terms and conditions set out in this document and (unless the context otherwise requires) any special terms and conditions agreed in writing between the Buyer and O-Shop ;
                    "Contract" means the contract for the purchase and sale of Goods, howsoever formed or concluded;
                    "Goods" means the goods (including any installment of the goods or any parts for them) which O-Shop is to supply in accordance with a Contract;
                    "Writing" includes electronic mail facsimile transmission and any comparable means of communication.</p>
                    <p><strong>1.2</strong> Any reference in these Conditions to any provision of a statute shall be construed as a reference to that provision as amended re-enacted or extended at the relevant time.</p>
                    <p><strong>1.3</strong> The headings in these Conditions are for convenience only and shall not affect the interpretation of any parties.</p>
                    <h5>2. Basis of the Contract</h5>
                    <p><strong>2.1 </strong>The supply of Goods by OpenSupermall to the Buyer under any Contract shall be subjected to these Conditions which shall govern the Contract to the exclusion of any other terms and conditions contained or referred to in any documentation submitted by the Buyer or in correspondence or elsewhere or implied by trade custom practice or course of dealing.</p>
                    <p><strong>2.2 </strong> Any information made available in OpenSupermall’s website connection with the supply of Goods, including photographs, drawings, data about the extent of the delivery, appearance, performance, dimensions, weight, consumption of operating materials, operating costs, are not binding and for information purposes only. In entering into the Contract the Buyer acknowledges that it does not rely on and waives any claim based on any such representations or information not so confirmed.</p>
                    <p><strong>2.3 </strong> No variation to these Conditions shall be binding unless agreed in writing between the authorised representatives of the Buyer and OpenSupermall.</p>
                    <p><strong>2.4</strong> Any typographical clerical or other error or omission in any quotation, invoice or other document or information issued by OpenSupermall in its website shall be subject to correction without any liability on the part of OpenSupermall.</p>
                    <h5>3. Orders and Specifications</h5>
                    <p><strong>3.1</strong> Order acceptance and completion of the contract between the Buyer and OpenSupermall will only be completed upon OpenSupermall issuing a confirmation of dispatch of the Goods to the Buyer. For the avoidance of doubt, OpenSupermall shall be entitled to refuse or cancel any order without giving any reasons for the same to the Buyer prior to issue of the confirmation of dispatch. OpenSupermallshall furthermore be entitled to require the Buyer to furnish OpenSupermall with contact and other verification information, including but not limited to address, contact numbers prior to issuing a confirmation of dispatch.</p>
                    <p><strong>3.2 No concluded Contract may be modified or cancelled by the Buyer except with the agreement in writing of OpenSupermall and on terms that the Buyer shall indemnify OpenSupermall in full against all loss (including loss of profit) costs (including the cost of all labour and materials used) damages charges and expenses incurred by OpenSupermall as a result of the modification or cancellation, as the case may be.</strong>
                    <h5>4. Price</h5>
                    <p><strong>4.1</strong>The price of the Goods and/or Services shall be the price stated in OpenSupermall’s website at the time which the Buyer makes its offer purchase to OpenSupermall. The price excludes the cost of packaging and delivery charges, any applicable goods and services tax, value added tax or similar tax which the Buyer shall be liable to pay to OpenSupermall in addition to the price.</p>
                    <h5>5. Terms of Payment</h5>
                    <p><strong>5.1</strong> The Buyer shall be entitled to make payment for the Goods pursuant to the various payment methods set out in OpenSupermall’s website. The terms and conditions applicable to each type of payment, as contained in OpenSupermall's website, shall be applicable to the Contract.</p>
                    <p><strong>5.2</strong> In addition to any additional terms contained in OpenSupermall’s website, the following terms shall also apply to the following types of payment:<br>
                    <b>5.2.1 Credit Card </b><br>
                    Credit Card payment option is available for all Buyers. OpenSupermall accepts all Visa and MasterCards, both Credit and Debit, and is 3D Secure (Verified by Visa, and MasterCard Secure) enabled. All your credit card information are protected by means of industry- leading encryption standards.
                    Please take note that additional charges may be incurred if you are using a non-Malaysian issues card due to Foreign Exchange.<br>
                    <b>5.2.2 Debit Cards</b><br>
                    OpenSupermall accepts all Malaysian Visa and MasterCard debit cards where subject to bank availability. All debit card numbers shall be protected by means of industry-leading encryption standards.
                   <b>5.2.3 Online Banking</b><br>
                    i. By choosing this payment method, the Buyer shall transfer the payment for the Goods to a OpenSupermall’s account for the total amount of the Buyer’s purchase (including any applicable taxes, fees and shipping costs). The transaction must be payable in Ringgit Malaysia. OpenSupermall, in its sole discretion, may refuse this payment option service to anyone or any user without notice for any reason at any time.<br>
                    ii. For the time being, OpenSupermall accepts online bank transfers from AmBank, Bank Islam, CIMB Bank, Hong Leong, Maybank, Public Bank, RHB.<br></p>
                    <h5>6. Delivery/Performance</h5>
                    <p><strong>6.1</strong> Delivery of the Goods shall be made to the address specified by the Buyer in its order.</p>
                    <p><strong>6.2</strong> OpenSupermall has the right at any time to sub-contract all or any of its obligations for the sale/delivery of the Goods to any other party as it may from time to time decide without giving notice of the same to the Buyer.
                    </p><p><strong>6.3</strong> Any dates quoted for delivery of the Goods are approximate only. The time for delivery/performance shall not be of the essence, and OpenSupermall shall not be liable for any delay in delivery or performance howsoever caused.</p>
                    <h5>7. Risk and property of the Goods</h5>
                    <p><strong>7.1</strong> Risk of damage to or loss of the Goods shall pass to the Buyer at the time of delivery or if the Buyer wrongfully fails to take delivery of the Goods, the time when OpenSupermall has tendered delivery of the Goods.
                    </p><p><strong>7.2</strong> Notwithstanding delivery and the passing of risk in the Goods or any other provision of these Conditions the property in the Goods shall not pass to the Buyer until OpenSupermall has received in cash or cleared funds payment in full of the price of the Goods and all other goods agreed to be sold by OpenSupermall to the Buyer for which payment is then due.</p>
                    <p><strong>7.3</strong> Until such time as the property in the Goods passes to the Buyer, the Buyer shall hold the Goods as OpenSupermall's fiduciary agent and bailee and shall keep the Goods separate from those of the Buyer.
                    </p><p><strong>7.4</strong> The Buyer agrees with OpenSupermall that the Buyer shall immediately notify OpenSupermall of any matter from time to time affecting OpenSupermall’s title to the Goods and the Buyer shall provide OpenSupermall with any in-formation relating to the Goods as OpenSupermall may require from time to time.</p>
                    <p><strong>7.5</strong> Until such time as the property in the Goods passes to the Buyer (and provided the Goods are still in existence and have not been resold) OpenSupermall shall be entitled at any time to demand the Buyer to deliver up the Goods to OpenSupermall and in the event of non-compliance OpenSupermall reserves it’s right to take legal action against the Buyer for the delivery up the Goods and also reserves its right to seek damages and all other costs including but not limited to legal fees against the Buyer.</p>
                    <p><strong>7.6</strong> The Buyer shall not be entitled to pledge or in any way charge by way of security for any indebtedness any of the Goods which remain the property of OpenSupermall but if the Buyer does so all moneys owing by the Buyer to OpenSupermall shall (without prejudice to any other right or remedy of OpenSupermall) forthwith become due and payable.</p>
                    <p><strong>7.7</strong> If the provisions in this Condition 7 are not effective according to the law of the country in which the Goods are located, the legal concept closest in nature to retention of title in that country shall be deemed to apply mutatis mutandis to give effect to the underlying intent expressed in this condition, and the Buyer shall take all steps necessary to give effect to the same.</p>
                    <p><strong>7.8</strong> The Buyer shall indemnify OpenSupermall against all loss damages costs expenses and legal fees in-curred by the Buyer in connection with the assertion and enforcement of OpenSupermall's rights under this condition.</p>

<h5>8. Cancellation and Return Policy</h5>
<p><strong>8.1</strong> Any request for cancellation can be made after payment for the product is completed AND must be made within 1 hour from the time of payment. Request for cancellation will only be approved if the product has not been shipped by the Merchant and the Buyer shall be entitled to refund. Request for cancellation will be rejected in the event that the Merchant has shipped the product.</p>
<p><strong>8.2</strong> Request for return of product purchased can be made after product is delivered. In the event that the product delivered is flawed, the Buyer shall return the product to the Merchant at the Buyer's own cost. Upon receiving the Merchant's confirmation on the approval for the request for return, such payment shall then be refunded to the Buyer.</p>
<p><strong>8.3</strong>	Request for return and/or refund shall be made within 7 days from the date of the delivery of the product. The Buyer shall not be entitled to refund and/or exchange if:</p>
a) The product requested for refund and/or exchange is used, destroyed and/or damaged.
<br>
b) The tag attached to the product is removed and/or tempered with.
<br>
c) The seal and/or package of the product is removed and/or opened.
<br>
d) The material(s) of the package product is lost.
<br>
e) The components of the product including product's accessory and/or free gifts which comes with the products have been used, destroyed, damaged and/or lost.
<br>
f) The product value is decreased and/or damaged due to, including but not limited to, any reason stated in (a) to (c) stated above and/or due to the delay by the Buyer in returning the product.
<br>
g) The product is custom made and/or is customized product.
<br>
h) The proof of purchase of product is not provided by the Buyer.
<br>
i) The Buyer failed to follow guidelines, manuals, instructions and/or recommendations provided by the products and/or the Vendor Merchant.
<br>
j) The product is of e-voucher type of product which is sent to the Buyers email directly and immediately. It is the buyer own responsibility to ensure the email address inserted and key is correct and accurate. OR
<br>
k) The product is of credit top-up type of product including but not limited to prepaid mobile air time, prepaid internet services, prepaid online content which is sent to Buyer's account directly and immediately. It is Buyer's own responsibility to ensure the account number (such as mobile telephone number, prepaid internet account number) inserted the key in is correct and accurate.
<br>

<p><strong>8.4</strong> All shipping cost and expenses paid are non-refundable and the Buyer shall bear for all the cost for the return and/or exchange of the product.</p>

<p><strong>8.5</strong> In the event of any refund and/or return is approved it is subject to deduction of shipping costs, taxes and/or any changes imposed by the online payment gateway and/or financial instructions.</p>

9. Social Media Marketer (“SMM”) 

9.1 Any user utilizing the website information to share such information at any social media shall be deemed as Social Media Marketer (“SMM”) for OpenSupermall.

9.2  Any information shared by SMM to public shall be at the own risk of SMM. 

9.3	OpenSupermall shall not be held responsible if the information is not shared out to the social media due to privacy setting by SMM on his/her own social media account, such as Facebook. 

9.3  Any OpenCredit points awarded to SMM shall not be converted to cash and is not transferable to third party. Such OpenCredit points is not intended to replace any physical and/or virtual currency .

9.4 No API connection or commercial use of the function without knowledge and authorization from OpenSupermall management. 

10. OpenWish 

10.1 OpenWish is a function provided by OpenSupermall to assist a Buyer to seek for assistance from the buyer’s buyer’s social network connections to purchase discount coupon that will be applied on the goods intended to be purchased by the Buyer.

10.2  Any information shared by any user using OpenWish shall be at their own risk. 

10.3 Any OpenCredit points awarded to Buyer under the OpenWish function shall not be converted to cash and is not transferable to third party. Such OpenCredit points is not intended to replace any physical and/or virtual currency.

10.4 OpenSupermall shall not be held responsible if the information is not shared out to the social media due to privacy setting by OpenWish on his/her own social media account, such as Facebook.

10.5 No API connection or commercial use of the function without knowledge and authorization from OpenSupermall management.

10.6	OpenSupermall shall charge 5% administration fees for any OpenWish Discount Coupon purchased.


11. Hyper

11.1 Hyper refers to a function provided by OpenSupermall to purchase a product together with other Buyers for the same product in bulk at a lower price.

11.2	The merchant and OpenSupermall has the rights to refund, if the product is not available at the point of maturity

12. Voucher

12.1 There shall be no cancellation and/or return on any voucher purchased.

12.2 Upon expiry of any unused voucher, 50% of the voucher value, in terms of OpenCredit points, shall be refunded to Buyer. Note that OpenCredit is a loyalty program of OpenSupermall, and the OpenCredit points is NOT exchangeable in lieu of money.

                    <h5>13. Force Majeure</h5>
                    <p><strong>13.1</strong> OpenSupermall shall not be liable to the Buyer or be deemed to be in breach of the Contract by reason of any delay in performing or any failure to perform any of OpenSupermall’s obligations if the delay or failure was due to any cause beyond OpenSupermall's reasonable control. Without prejudice to the generality of the foregoing the following shall be regarded as causes beyond OpenSupermall's reasonable control:<br>
                    <b>13.1.1</b> Act of God, explosion, flood, tempest, fire or accident;<br>
                    <b>13.1.2</b> war or threat of war, sabotage, insurrection, civil disturbance or requisition;<br>
                    <b>13.1.3</b> acts of restrictions, regulations, bye-laws, prohibitions or measures of any kind on the part of any governmental parliamentary or local authority;<br>
                    <b>13.1.4</b> import or export regulations or embargoes;
                    <br><b>13.1.5</b> interruption of traffic, strikes, lock-outs, other industrial actions or trade disputes (whether involving employees of OpenSupermall or of a third party);
                    <br><b>13.1.6</b> interruption of production or operation, difficulties in obtaining raw materials labour fuel parts or machinery;
                    <br><b>13.1.7</b> power failure or breakdown in machinery.</p>
                    <p><strong>13.2</strong> Upon the happening of any one of the events set out in Condition 13.1 OpenSupermall may at its option:-
                    <br><b>13.2.1</b> fully or partially suspend delivery/performance while such event or circumstances continues;
                    <br><b>13.2.2</b> terminate any Contract so affected with immediate effect by written notice to the Buyer and OpenSupermall shall not be liable for any loss or damage suffered by the Buyer as a result thereof.</p>
                    <h5>14. Notices</h5>
                    Any notice required or permitted to be given by either party to the other under these Conditions shall be in writing addressed, if to OpenSupermall, to its registered office or principal place of business and if to the Buyer, to the address stipulated in the relevant offer to purchase.
                    OpenSupermall reserves their right to these terms and conditions of sale at any time. --}}
            {{-- Copy from above --}}
          </div>
        </div>
	   </div>
		   <!--
		   <div class="container text-center" style="margin-top:20px;">
			  {!!Form::submit("Disagree", array("name"=>"disagree","class"=>'btn btn-warning'))!!}
			  {!!Form::submit("Agree", array("name"=>"agree","class"=>'btn btn-success'))!!}
			  
			  <br><br>
		   </div>
		   -->
	</div>
	</div>
</div>
<br>
<br>

@stop
