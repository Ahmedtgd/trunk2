<?php

use Illuminate\Database\Seeder;

class Fsection_aSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
$about_us = '
<div class="container">
  <div class="row" style="margin-bottom:10px;">
    <div class="col-sm-12">
      <img src="/images/Buyerregistration.png" title="banner" class="img-responsive">
    </div>
    <div class="col-sm-12 about-content">
      <h2 class="page-title">About Us</h2>
        <div class="jp-merchants text-justify">
          <p>OpenSupermall is a new generation of e commerce portal that covers branding,marketing,sales and business solutions. Its business partners are selected based on their respective reputations in the various areas and the primary emphasis are an product authencity, customer satisfaction and continuity of business relationship among the platform owner, business owner and customers.</p>
          <p>Our platform enhanced features allow the business partners to carry out the Business-to-Business (B2B) and Business-to-Customer (B2C) transaction effectively and precisely. Furthermore, we incorporate processes and operations to make sure that every single deal is a fair deal.</p>
          <p>Our logo, the OpenRing, represent the commonwealth and sharing amoung the people in the day to day without discrimination in race, religion and nationality. The rainbow like color band represents the element of OpenSupermall; the incredible variety and diversity of products and services we offer.</p>
          <p>If you are B2B and B2C, market players, please do not hestitate to contact us.</p>
        </div>
    </div>
  </div>
</div>
<br><br>';

        $private_policy = '
       <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Privacy Policy</h2>
            </div>
            <div class="panel-body">
                <p>We take our customer&rsquo;s privacy seriously and we will only collect, record, hold, store and use
                    your personal information as outlined below.</p>
                <p>Data protection is a matter of trust and your privacy is important to us. We shall therefore only
                    process your name and other information which relates to you in the manner set out in this Privacy
                    Policy.</p>
                <p>Intermedius OpenSupermall Sdn Bhd and its affiliates ("Company"), may take your personal information
                    when you communicate with us either by log in to our website or contact to our customer service and
                    the information that we collected from you may be used and will be kept confidential. In order to
                    protect your private information, we have established this Privacy Policy (the "Policy") in
                    accordance with best practices in the industry and applicable laws and regulations. This Policy
                    describes how we handle your personal information for our services on the opensupermall.com website
                    and its related sites, services and tools (the "Website").</p>
                <p>By accepting the Policy, Terms &amp; Conditions in registration, you expressly consent to our
                    collection, storage, use and disclosure of your personal information as described in this
                    Policy.</p>
                <h3>Collection of Personal Information</h3>
                <p>You can browse our sites without telling us who you are or revealing any personal information about
                    yourself. Once you give us your personal information, you are not anonymous to us.</p>
                <p>We may collect and store the following personal information:</p>
                <ul>
                    <li>email address, physical contact information, the date of birth and gender information, and
                        (depending on the service used) sometimes financial information, such as credit card or bank
                        account numbers;
                    </li>
                    <li>transactional information based on your activities on the Website</li>
                    <li>postage, billing and other information you provide to purchase or dispatch an item;</li>
                    <li>community discussions, chats, dispute resolution, correspondence through our Website, and
                        correspondence sent to us;
                    </li>
                    <li>other information from your interaction with our Website, services, content and advertising,
                        including computer and connection information, statistics on page views, traffic to and from the
                        Website, ad data, IP address and standard web log information;
                    </li>
                    <li>additional information we ask you to submit to authenticate yourself or if we believe you are
                        violating site policies (for example, we may ask you to send us an ID or bill to verify your
                        address, or to answer additional questions online to help verify your identity or ownership of
                        an item you list);
                    </li>
                    <li>information from other companies, such as demographic and navigation data; and</li>
                    <li>other supplemental information from third parties (for example, if you incur a debt to the
                        Company, we will generally conduct a credit check by obtaining additional information about you
                        from a credit bureau, as permitted by law).
                    </li>
                </ul>
                <p>All personal data shall be provided by you voluntarily unless where it is indicated as mandatory.
                    Where the personal data is mandatory to be provided, failure to provide such information may result
                    in Company not being able to process your request</p>
                <h3>Use</h3>
                <p>Our primary purpose in collecting personal information is to provide you with a safe, smooth,
                    efficient and customized experience. You agree that we may use your personal information to:</p>
                <ul>
                    <li>Provide the services and customer support you request;</li>
                    <li>Resolve disputes, collect fees, and troubleshoot problems;</li>
                    <li>Prevent potentially prohibited or illegal activities, and enforce our User Agreement;</li>
                    <li>Customize, measure and improve our services, content and advertising;</li>
                    <li>Tell you about our services and those of our corporate family;</li>
                    <li>Send you targeted marketing, service updates, and promotional offers; and</li>
                    <li>Compare information for accuracy, and verify it with third parties.</li>
                    <li>Provide aggregate information to our partners about our users (e.g. 500 men under age 30 have
                        viewed this item) without disclosing information about identifiable individuals.
                    </li>
                </ul>
                <h3>Denial of Collection</h3>
                <p>You may withdraw your consent to our collection of your personal data and/or information at any time
                    by notifying us or call our customer service. In that event, we will not be able to identify you and
                    provide you with a safe, smooth, efficient and customized experience while using our site. Although
                    you can browse through most of our sites without giving any information about yourself, in some
                    cases, personal information is required in order to provide the Services you request.</p>
                <h3>Our Disclosure of Your Information</h3>
                <p>We may disclose personal information to respond to legal requirements, enforce our policies, respond
                    to claims that a listing or other content violates the rights of others, or protect anyone\'s rights,
                    property, or safety. Such information will be disclosed in accordance with applicable laws and
                    regulations.</p>
                <h3>Share of Your Information</h3>
                <p>We may share your personal information, within or outside Malaysia, with:</p>
                <ul>
                    <li>Third-party service providers under contract who help with our business operations: We employ
                        other companies and individuals to perform functions on our behalf. Examples include fulfilling
                        orders, delivering packages, sending postal mail and e-mail, removing repetitive information
                        from customer lists, analyzing data, providing marketing assistance, providing search results
                        and links(including paid listings and links), processing credit card payments, investigating
                        frauds and providing customer service. They have access to personal information needed to
                        perform their functions, but may not use it for other purposes.
                    </li>
                    <li>Third parties giving promotional offers: Sometimes we send offers to selected groups our users
                        on behalf of other businesses. When we do this, we do not give that business your name and
                        address. If you do not want to receive such offers, please adjust communication preferences in
                        My Page.
                    </li>
                    <li>Other third parties to whom you explicitly ask us to send your information (or about whom you
                        are otherwise explicitly notified and consent to when using a specific service).
                    </li>
                    <li>Law enforcement or other governmental officials, in response to a verified request relating to a
                        criminal investigation or alleged illegal activity. In such events, we will disclose information
                        relevant to the investigation, such as name, city, postal code, telephone number, email address,
                        User ID history, IP address, fraud complaints, and purchasing and listing history;
                    </li>
                    <li>Brand Protection Program participants under confidentiality agreement, as we in our sole
                        discretion believe necessary or appropriate in connection with an investigation of fraud,
                        intellectual property infringement, piracy, or other unlawful activity. In such events, we will
                        disclose name, street address, city, postal code,country, phone number, email address and
                        company name; and
                    </li>
                    <li>Other business entities, should we plan to merge with or be acquired by that business entity.
                        (Should such a combination occur, we will require that the new combined entity follow this
                        Policy with respect to your personal information. If your personal information will be used
                        contrary to this policy, you will receive prior notice.)
                    </li>
                </ul>
                <p>For the avoidance of doubt, If Company has reasonable grounds to believe that any User is in breach
                    of any of the terms of this Policy, Company reserves the right, in its sole and absolute discretion,
                    to cooperate fully with governmental authorities, private investigators, all the rightful owner(s)
                    or interest holder(s) and/or injured third parties in the investigation of any potential or ongoing
                    criminal or civil wrongdoing. Further, Company may disclose the User\'s identify and contact
                    information, or such other transaction-related data, if requested by a government or law enforcement
                    body, private investigator, rightful owner or interest holder and/or any injured third party or as a
                    result of a subpoena or other legal action, or if Company is of the view, in its sole and absolute
                    discretion, that it would be in its best interest to do so. Company shall not be liable for damages
                    or results arising from such disclosure, and the User(s) agrees not to bring action or claim against
                    Company for such disclosure.</p>
                <h3>Using Information from this Website</h3>
                <p>We enable you to share personal information to complete transactions. When users are involved in a
                    transaction, they may have access to each other\'s name, user ID, email address and other contact and
                    postage information. In all cases, you must comply with data protection laws, and give other users a
                    chance to remove themselves from your database and a chance to review what information you have
                    collected about them.</p>
                <p>You agree to use user information only for:</p>
                <ul>
                    <li>fulfillment of the transaction through this website and purposes related to the transaction;
                    </li>
                    <li>using services offered through this website (e.g. escrow, postage and fraud complaints); or</li>
                    <li>other purposes that a user expressly chooses.</li>
                </ul>
                <h3>Account Protection</h3>
                <p>Your password is the key to your account. Use unique numbers and letters and do not disclose your
                    password to anyone. If you do share your password or your personal information with others, remember
                    that you are responsible for all actions taken in the name of your account. If you lose control of
                    your password, you may lose substantial control over your personal information and may be subject to
                    legally binding actions taken on your behalf. Therefore, if your password has been compromised for
                    any reason, you should immediately notify us and change your password.</p>
                <p>We will never ask for your password by phone or e-mail, so if you receive such an inquiry, please
                    report the incident to the Security &amp; Resolution Center or the Personal Information Manager.</p>
                <p>If you access our Website from a shared computer or a computer in an internet cafe, a PC room or a
                    library, certain information about you, such as your user ID, activity or reminders from the
                    Website, may also be visible to other individuals who use the computer after you. To protect your
                    personal information or communication from being disclosed to others, you should log out and close
                    the web browser after using our Website</p>
                <h3>Accessing, Reviewing, Changing and Retaining Your Personal Information</h3>
                <p>You can see, review and change most of your personal information by signing on to the Website.
                    Generally, we will not manually modify your personal information because it is very difficult to
                    verify your identity remotely. You must promptly update your personal information if it changes or
                    becomes inaccurate. Once you make a public posting, you may not be able to change or remove it. Upon
                    your request to the customer service, we will close your account and remove your personal
                    information from view as soon as reasonably possible, based on your account activity and in
                    accordance with applicable law. We do retain personal information from closed accounts to comply
                    with law, prevent fraud, collect any fees owed, resolve disputes, troubleshoot problems, assist with
                    any investigations, enforce our User Agreement, and take other actions otherwise permitted by law.
                    Otherwise, your personal information will be destroyed by us once we confirm there is no use for
                    it.</p>
                <h3>Security</h3>
                <p>Your information is stored on our servers located in the Malaysia. We treat data as an asset that
                    must be protected and use lots of tools (encryption, passwords, physical security, etc.) to protect
                    your personal information against unauthorised access and disclosure. However, as you probably know,
                    third parties may unlawfully intercept or access transmissions or private communications, and other
                    users may abuse or misuse your personal information that they collect from the site. Therefore,
                    although we work very hard to protect your privacy, we do not promise, and you should not expect,
                    that your personal information or private communications will always remain private</p>
                <h3>Third Parties</h3>
                <p>Except as otherwise expressly included in this Policy, this document addresses only the use and
                    disclosure of information we collect from you. If you disclose your information to others, whether
                    they are buyers or sellers on our Website or other sites throughout the Internet, different rules
                    may apply to their use or disclosure of the information you disclose to them. We do not control the
                    privacy policies of third parties, and you are subject to the privacy policies of those third
                    parties where applicable. We encourage you to ask questions and to review their privacy policies
                    before you disclose your personal information to others.</p>
                <h3>Consent</h3>
                <p>By continuing to use Website, you consent to the processing of your personal data in accordance with
                    the Privacy Policy Policy, Terms &amp; Conditions and Seller Agreement by Company.</p>
                <h3>Changes to the Privacy Policy</h3>
                <p>Intermedius Open Supermall Sdn Bhd reserves the right to modify and change the Privacy Policy Policy
                    at any time. Any changes to this policy will be published on our website. You should check this
                    Policy each time you access our website so as to be aware of the most recent applicable version of
                    the Policy.</p>
            </div>
        </div>';
		$terms_and_conditions = '
			                  <textarea class="form-control" rows="5" id="comment" placeholder="Load T & C" style="height:600px ; width:95%; margin:20px;  margin-right:20px" onblur="validate()" required>
                    Terms & Conditions
                    INTRODUCTION
                    Welcome to the OpenSupermall.com website (the "Site"). These terms and conditions ("Terms and Conditions") apply to the Site, Intermedius OpenSupermall Sdn Bhd , and all of its divisions, subsidiaries, and affiliate operated Internet sites which reference these Terms and Conditions.
                    By accessing the Site, you confirm your understanding of the Terms and Conditions. If you do not agree to these Terms and Conditions of use, you shall not use this website. The Site reserves the right, to change, modify, add, or remove portions of these Terms and Conditions of use at any time. Changes will be effective when posted on the Site with no other notice provided. Please check these Terms and Conditions of use regularly for updates. Your continued use of the Site following the posting of changes to these Terms and Conditions of use constitutes your acceptance of those changes.
                    USE OF THE SITE
                    We grant you a non-transferable and revocable license to use the Site, under the Terms and Conditions described, for the purpose of shopping for personal items sold on the Site. Commercial use or use on behalf of any third party is prohibited, except as explicitly permitted by us in advance. Any breach of these Terms and Conditions shall result in the immediate revocation of the license granted in this paragraph without notice to you.
                    Content provided on this site is solely for informational purposes. Product representations expressed on this Site are those of the vendor and are not made by us. Submissions or opinions expressed on this Site are those of the individual posting such content and may not reflect our opinions.
                    Certain services and related features that may be made available on the Site may require registration or subscription. Should you choose to register or subscribe for any such services or related features, you agree to provide accurate and current information about yourself, and to promptly update such information if there are any changes. Every user of the Site is solely responsible for keeping passwords and other account identifiers safe and secure. The account owner is entirely responsible for all activities that occur under such password or account. Furthermore, you must notify us of any unauthorized use of your password or account. The Site shall not be responsible or liable, directly or indirectly, in any way for any loss or damage of any kind incurred as a result of, or in connection with, your failure to comply with this section.
                    USER SUBMISSIONS
                    Anything that you submit to the Site and/or provide to us, including but not limited to, questions, reviews, comments, and suggestions (collectively, "Submissions") will become our sole and exclusive property and shall not be returned to you. In addition to the rights applicable to any Submission, when you post comments or reviews to the Site, you also grant us the right to use the name that you submit, in connection with such review, comment, or other content. You shall not use a false e-mail address, pretend to be someone other than yourself or otherwise mislead us or third parties as to the origin of any Submissions. We may, but shall not be obligated to, remove or edit any Submissions.
                    ORDER ACCEPTANCE AND PRICING
                    Please note that there are cases when an order cannot be processed for various reasons. The Site reserves the right to refuse or cancel any order for any reason at any given time. You may be asked to provide additional verifications or information, including but not limited to phone number and address, before we accept the order.
                    We are determined to provide the most accurate pricing information on the Site to our users; however, errors may still occur, such as cases when the price of an item is not displayed correctly on the website. As such, we reserve the right to refuse or cancel any order. In the event that an item is mispriced, we may, at our own discretion, either contact you for instructions or cancel your order and notify you of such cancellation. We shall have the right to refuse or cancel any such orders whether or not the order has been confirmed and your credit card or bank account charged.
                    GST
                    GST will be implemented in Malaysia with effect from 1 April 2015 at the rate of 6%. It will replace the existing sales tax and service tax. Prices of Items and services provided by Intermedius Open Supermall Sdn Bhd, being GST registered company, will include GST where applicable.
                    Please refer to the GST Act 2014 published in the gazette on 19 June 2014 and the GST Regulations 2014 issued on 30 June 2014. GST is under the jurisdiction of the Royal Malaysian Customs Department (“Customs Department”).
                    TRADEMARKS AND COPYRIGHTS
                    All intellectual property rights, whether registered or unregistered, in the Site, information content on the Site and all the website design, including, but not limited to, text, graphics, software, photos, video, music, sound, and their selection and arrangement, and all software compilations, underlying source code and software shall remain our property. The entire contents of the Site also are protected by copyright as a collective work under Malaysia copyright laws and international conventions. All rights are reserved.
                    APPLICABLE LAW AND JURISDICTION
                    These Terms and Conditions shall be interpreted and governed by the laws in force in Malaysia. Subject to the Arbitration section below, each party hereby agrees to submit to the jurisdiction of the courts of Government of Malaysia to waive any objections based upon venue.
                    ARBITRATION
                    Any controversy, claim or dispute arising out of or relating to these Terms and Conditions will be referred to and finally settled by private and confidential binding arbitration before a single arbitrator held in Malaysia in English and governed by Malaysian law. The arbitrator shall be a person who is legally trained and who has experience in the information technology field in Malaysia and is independent of either party. Notwithstanding the foregoing, the Site reserves the right to pursue the protection of intellectual property rights and confidential information through injunctive or other equitable relief through the courts.
                    TERMINATION
                    In addition to any other legal or equitable remedies, we may, without prior notice to you, immediately terminate the Terms and Conditions or revoke any or all of your rights granted under the Terms and Conditions. Upon any termination of this Agreement, you shall immediately cease all access to and use of the Site and we shall, in addition to any other legal or equitable remedies, immediately revoke all password(s) and account identification issued to you and deny your access to and use of this Site in whole or in part. Any termination of this agreement shall not affect the respective rights and obligations (including without limitation, payment obligations) of the parties arising before the date of termination. You furthermore agree that the Site shall not be liable to you or to any other person as a result of any such suspension or termination.
                    Terms of Use

                    1. Interpretation
                    1.1 In these Conditions:
                    "Buyer" means the person who accepts a quotation of OpenSupermall for the supply of Goods or who otherwise enters into a contract for the supply of Goods with OpenSupermall ;
                    "Conditions" mean the general terms and conditions set out in this document and (unless the context otherwise requires) any special terms and conditions agreed in writing between the Buyer and O-shop ;
                    "Contract" means the contract for the purchase and sale of Goods, howsoever formed or concluded;
                    "Goods" means the goods (including any installment of the goods or any parts for them) which O-shop is to supply in accordance with a Contract;
                    "Writing" includes electronic mail facsimile transmission and any comparable means of communication.
                    1.2 Any reference in these Conditions to any provision of a statute shall be construed as a reference to that provision as amended re-enacted or extended at the relevant time.
                    1.3 The headings in these Conditions are for convenience only and shall not affect the interpretation of any parties.
                    2. Basis of the Contract
                    2.1 The supply of Goods by OpenSupermall to the Buyer under any Contract shall be subjected to these Conditions which shall govern the Contract to the exclusion of any other terms and conditions contained or referred to in any documentation submitted by the Buyer or in correspondence or elsewhere or implied by trade custom practice or course of dealing.
                    2.2 Any information made available in OpenSupermall’s website connection with the supply of Goods, including photographs, drawings, data about the extent of the delivery, appearance, performance, dimensions, weight, consumption of operating materials, operating costs, are not binding and for information purposes only. In entering into the Contract the Buyer acknowledges that it does not rely on and waives any claim based on any such representations or information not so confirmed.
                    2.3 No variation to these Conditions shall be binding unless agreed in writing between the authorised representatives of the Buyer and OpenSupermall.
                    2.4 Any typographical clerical or other error or omission in any quotation, invoice or other document or information issued by OpenSupermall in its website shall be subject to correction without any liability on the part of OpenSupermall.
                    3. Orders and Specifications
                    3.1 Order acceptance and completion of the contract between the Buyer and OpenSupermall will only be completed upon OpenSupermall issuing a confirmation of dispatch of the Goods to the Buyer. For the avoidance of doubt, OpenSupermall shall be entitled to refuse or cancel any order without giving any reasons for the same to the Buyer prior to issue of the confirmation of dispatch. OpenSupermallshall furthermore be entitled to require the Buyer to furnish OpenSupermall with contact and other verification information, including but not limited to address, contact numbers prior to issuing a confirmation of dispatch.
                    3.2 No concluded Contract may be modified or cancelled by the Buyer except with the agreement in writing of OpenSupermall and on terms that the Buyer shall indemnify OpenSupermall in full against all loss (including loss of profit) costs (including the cost of all labour and materials used) damages charges and expenses incurred by OpenSupermall as a result of the modification or cancellation, as the case may be.
                    4. Price
                    The price of the Goods and/or Services shall be the price stated in OpenSupermall’s website at the time which the Buyer makes its offer purchase to OpenSupermall. The price excludes the cost of packaging and delivery charges, any applicable goods and services tax, value added tax or similar tax which the Buyer shall be liable to pay to OpenSupermall in addition to the price.
                    5. Terms of Payment
                    5.1 The Buyer shall be entitled to make payment for the Goods pursuant to the various payment methods set out in OpenSupermall’s website. The terms and conditions applicable to each type of payment, as contained in OpenSupermall\'s website, shall be applicable to the Contract.
                    5.2 In addition to any additional terms contained in OpenSupermall’s website, the following terms shall also apply to the following types of payment:
                    5.2.1 Credit Card
                    Credit Card payment option is available for all Buyers. OpenSupermall accepts all Visa and MasterCards, both Credit and Debit, and is 3D Secure (Verified by Visa, and MasterCard Secure) enabled. All your credit card information are protected by means of industry- leading encryption standards.
                    Please take note that additional charges may be incurred if you are using a non-Malaysian issues card due to Foreign Exchange.
                    5.2.2 Debit Cards
                    OpenSupermall accepts all Malaysian Visa and MasterCard debit cards where subject to bank availability. All debit card numbers shall be protected by means of industry-leading encryption standards.
                    5.2.3 Online Banking
                    i. By choosing this payment method, the Buyer shall transfer the payment for the Goods to a OpenSupermall’s account for the total amount of the Buyer’s purchase (including any applicable taxes, fees and shipping costs). The transaction must be payable in Ringgit Malaysia. OpenSupermall, in its sole discretion, may refuse this payment option service to anyone or any user without notice for any reason at any time.
                    ii. For the time being, OpenSupermall accepts online bank transfers from AmBank, Bank Islam, CIMB Bank, Hong Leong, Maybank, Public Bank, RHB.
                    6. Delivery/Performance
                    6.1 Delivery of the Goods shall be made to the address specified by the Buyer in its order.
                    6.2 OpenSupermall has the right at any time to sub-contract all or any of its obligations for the sale/delivery of the Goods to any other party as it may from time to time decide without giving notice of the same to the Buyer.
                    6.3 Any dates quoted for delivery of the Goods are approximate only. The time for delivery/performance shall not be of the essence, and OpenSupermall shall not be liable for any delay in delivery or performance howsoever caused.
                    7. Risk and property of the Goods
                    7.1 Risk of damage to or loss of the Goods shall pass to the Buyer at the time of delivery or if the Buyer wrongfully fails to take delivery of the Goods, the time when OpenSupermall has tendered delivery of the Goods.
                    7.2 Notwithstanding delivery and the passing of risk in the Goods or any other provision of these Conditions the property in the Goods shall not pass to the Buyer until OpenSupermall has received in cash or cleared funds payment in full of the price of the Goods and all other goods agreed to be sold by OpenSupermall to the Buyer for which payment is then due.
                    7.3 Until such time as the property in the Goods passes to the Buyer, the Buyer shall hold the Goods as OpenSupermall\'s fiduciary agent and bailee and shall keep the Goods separate from those of the Buyer.
                    7.4 The Buyer agrees with OpenSupermall that the Buyer shall immediately notify OpenSupermall of any matter from time to time affecting OpenSupermall’s title to the Goods and the Buyer shall provide OpenSupermall with any in-formation relating to the Goods as OpenSupermall may require from time to time.
                    7.5 Until such time as the property in the Goods passes to the Buyer (and provided the Goods are still in existence and have not been resold) OpenSupermall shall be entitled at any time to demand the Buyer to deliver up the Goods to OpenSupermall and in the event of non-compliance OpenSupermall reserves it’s right to take legal action against the Buyer for the delivery up the Goods and also reserves its right to seek damages and all other costs including but not limited to legal fees against the Buyer.
                    7.6 The Buyer shall not be entitled to pledge or in any way charge by way of security for any indebtedness any of the Goods which remain the property of OpenSupermall but if the Buyer does so all moneys owing by the Buyer to OpenSupermall shall (without prejudice to any other right or remedy of OpenSupermall) forthwith become due and payable.
                    7.8 If the provisions in this Condition 7 are not effective according to the law of the country in which the Goods are located, the legal concept closest in nature to retention of title in that country shall be deemed to apply mutatis mutandis to give effect to the underlying intent expressed in this condition, and the Buyer shall take all steps necessary to give effect to the same.
                    7.9 The Buyer shall indemnify OpenSupermall against all loss damages costs expenses and legal fees in-curred by the Buyer in connection with the assertion and enforcement of OpenSupermall\'s rights under this condition.
                    8. Force Majeure
                    9.1 OpenSupermall shall not be liable to the Buyer or be deemed to be in breach of the Contract by reason of any delay in performing or any failure to perform any of OpenSupermall’s obligations if the delay or failure was due to any cause beyond OpenSupermall\'s reasonable control. Without prejudice to the generality of the foregoing the following shall be regarded as causes beyond OpenSupermall\'s reasonable control:
                    8.1.1 Act of God, explosion, flood, tempest, fire or accident;
                    8.1.2 war or threat of war, sabotage, insurrection, civil disturbance or requisition;
                    8.1.3 acts of restrictions, regulations, bye-laws, prohibitions or measures of any kind on the part of any governmental parliamentary or local authority;
                    8.1.4 import or export regulations or embargoes;
                    8.1.5 interruption of traffic, strikes, lock-outs, other industrial actions or trade disputes (whether involving employees of OpenSupermall or of a third party);
                    8.1.6 interruption of production or operation, difficulties in obtaining raw materials labour fuel parts or machinery;
                    8.1.7 power failure or breakdown in machinery.
                    8.2 Upon the happening of any one of the events set out in Condition 8.1 OpenSupermall may at its option:-
                    8.2.1 fully or partially suspend delivery/performance while such event or circumstances continues;
                    8.2.2 terminate any Contract so affected with immediate effect by written notice to the Buyer and Lazada shall not be liable for any loss or damage suffered by the Buyer as a result thereof.
                    10. Notices
                    Any notice required or permitted to be given by either party to the other under these Conditions shall be in writing addressed, if to OpenSupermall, to its registered office or principal place of business and if to the Buyer, to the address stipulated in the relevant offer to purchase.
                    OpenSupermall reserves their right to these terms and conditions of sale at any time.
                  </textarea>';

    $how_to_buy = '
<style type="text/css">
    .part-svn-content-desc, .part-four-content-desc p {
         font-size: inherit;
    }
    strong {
        font-size: 16px;
    }
    .list ul{
        padding: 20px;
    }

</style>

<section id="content"> 
    <div class="content">
        <div class="container">

            <div class="slide-image slide-buy-back">
                <center> <img src="/images/slide.jpeg" alt="slide" class="img-responsive"> </center>
            </div><!-- slide image end -->
        </div><!-- container end -->

        <div class="container">
            <div class="section-heading">
                <h2>How To Buy ?</h2>
            </div>
            <div class="section-content buy-image">
                <div class="part-one">
                    <div class="part-one-image">
                        <img src="/images/tabs.jpg" alt="Welcome">
                    </div><!-- part-one-image end -->

                    <div class="part-one-left-line">
                        <canvas id="part-one" width="30" height="170"></canvas>
                    </div><!-- part-one-left-line end -->

                    <div class="part-one-content">
                        <div class="part-one-content-heading">
                            <strong> Register an account with OpenSupermall.com </strong>
                            <div class="part-one-content-desc list">
                                <ul>
                                    <li> Click the "Sign in" or "Sign Up" button if you have not registered an account.</li>
                                    <li> Fill up buyer registration form.</li>
                                    <li>If you are facing any problems, please do call out help line : <span>+6012-272 0667</span></li>
                                </ul>
                            </div>
                        </div><!-- part-one-content-heading end -->
                    </div><!-- part-one-content end -->

                    <div class="part-one-number">
                        <span>1</span>
                    </div><!-- part-one end -->

                    <div class="clearfix"></div>
                </div><!-- part-one-number end -->

                <div class="end-line">
                    <canvas id="end-line" width="150" height="16"></canvas>
                </div><!-- end-line -->

                <div class="part-two">
                    <div class="part-two-number">
                        <span>2</span>
                    </div><!-- part-two-number end -->

                    <div class="part-two-content">
                        <div class="part-two-content-heading">
                            <div class="part-two-content-desc">
                                <strong>After successful registration, login to your own profile</strong>
                            </div>
                        </div>
                    </div><!-- part-two-content end -->

                    <div class="part-two-image">
                        <img src="/images/computer.png" alt="welcome">
                    </div><!-- part-two-image end -->
                    <div class="clearfix"></div>

                </div><!-- part-two end -->

                <div class="part-three">
                    <div class="part-three-line">
                        <canvas id="part-three" width="100" height="130"></canvas>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- part-three -->


                <div class="end-line">
                    <canvas id="end-line-1" width="150" height="16"></canvas>
                </div><!-- end-line -->


                <div class="part-four">
                    <div class="part-four-image">
                        <img src="/images/computer2.jpg" alt="welcome">
                    </div><!-- part-four-image end -->

                    <div class="part-four-content">
                        <div class="part-four-content-heading">
                            <strong> Select your product </strong>
                            <div class="part-four-content-desc list">
                                <ul>
                                    <li> Choose your fevorite product, and put them in your shopping cart.</li>
                                    <li> Choose the shipping option.</li>
                                    <li> Read the terms &amp; Conditions and agree.</li>
                                    <li> Read the Refund &amp; Refund policy and agree.</li>

                                </ul>
                            </div>
                        </div><!-- part-four-content-heading end -->
                    </div><!-- part-four-content end -->

                    <div class="part-four-number">
                        <span>3</span>
                    </div><!-- part-four-number end -->

                    <div class="part-four-line">
                        <canvas id="part-four" width="200" height="250"></canvas>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- part-four-number end -->


                <div class="end-line">
                    <canvas id="end-line-2" width="150" height="16"></canvas>
                </div><!-- end-line -->


                <div class="part-five">
                    <div class="part-five-number">
                        <span>4</span>
                    </div><!-- part-five-number end -->

                    <div class="part-five-image">
                        <img src="/images/mail.jpg" alt="welcome">
                    </div><!-- part-five-image end -->

                    <div class="part-five-content">
                        <div class="part-five-content-heading">
                            <strong> Make payment </strong>
                            <div class="part-five-content-desc list">
                                <ul>
                                    <li> View your shopping cart.</li>
                                    <li> Go through your order list.</li>
                                    <li> Once satisfied, select option to make payment.</li>
                                    <li> Read the terms &amp; conditions and agree.</li>
                                </ul>
                            </div>
                        </div><!-- part-five-content-heading end -->
                    </div><!-- part-five-content end -->

                    <div class="clearfix"></div>
                </div><!-- part-five-number end -->

                <div class="part-six">
                    <div class="part-six-line">
                        <canvas id="part-six" width="200" height="250"></canvas>
                    </div>
                </div><!-- part-six end -->

                <div class="end-line">
                    <canvas id="end-line-3" width="150" height="16"></canvas>
                </div><!-- end-line -->

                <div class="part-svn">
                    <div class="part-svn-image">
                        <img src="/images/po.jpg" alt="welcome">
                    </div><!-- part-svn-image end -->
                    <div class="part-svn-content">
                        <div class="part-svn-content-heading">
                            <strong> Check your purchase order list </strong>
                            <div class="part-svn-content-desc">
                                <ul><li> Keep track of your confirmed purchase order by head to order management at your profile .</li></ul>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- part-svn-content-heading end -->
                    </div><!-- part-svn-content end -->
                    <div class="part-svn-number">
                        <span>5</span>
                    </div><!-- part-svn-number end -->
                    <div class="clearfix"></div>
                </div><!-- part-svn-number end -->

                <div class="adjust">
                    <div class="part-eight">
                        <div class="part-eight-line">
                            <canvas id="part-eight" width="100" height="150"></canvas>
                        </div>
                    </div><!-- part-eight end -->
                </div>

                <div class="end-line">
                    <canvas id="end-line-4" width="150" height="16"></canvas>
                </div><!-- end-line -->

                <div class="part-nine">
                    <div class="part-nine-number">
                        <span>6</span>
                    </div><!-- part-nine-number end -->

                    <div class="part-nine-image">
                        <img src="/images/transport.jpg" alt="welcome">
                    </div><!-- part-nine-image end -->

                    <div class="part-nine-content">
                        <div class="part-nine-content-heading">
                            <br>
                            <strong> Product Delivery </strong>
                            <div class="part-nine-content-desc list">
                                <ul>
                                    <li> The product will be shipped to your state location within 10 business days in accordance to your shipping service.</li>
                                    <li> Track our purchase order at your own profile list.</li>
                                    <li> Order tracking number will be sent to you via email.</li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- part-nine-content-heading end -->
                    </div><!-- part-nine-content end -->
                    <div class="clearfix"></div>
                </div><!-- part-nine-number end -->

                <div class="end-line">
                    <canvas id="end-line-5" width="150" height="16"></canvas>
                </div><!-- end-line -->

            </div><!-- buy image end -->
        </div><!-- container end -->
    </div><!-- content end --> 
</section>';                  
		$how_to_sell= '
<style type="text/css">
    .part-svn-content-desc, .part-four-content-desc p {
     font-size: inherit;
 }
 strong {
    font-size: 16px;
}
.list ul{
    padding: 20px;
}

</style>


<section id="content">
    <div class="content">
        <div class="container">
            <div class="slide-image slide-sell-back">
                <center>
                    <img src="/images/slide.jpeg" alt="slide" class="img-responsive">
                </center>
            </div><!-- slide image end -->
        </div><!-- container end -->

        <div class="container">
            <div class="section-heading">
                <h2>How To Sell ?</h2>
            </div>
            <div class="section-content sell-image">

                <div class="part-one">
                    <div class="part-one-image">
                        <img src="/images/tabs.jpg" class="Welcome">
                    </div><!-- part-one-image end -->

                    <div class="part-one-left-line">
                        <canvas id="part-one" width="30" height="170"></canvas>
                    </div><!-- part-one-left-line end -->

                    <div class="part-one-content">
                        <div class="part-one-content-heading">
                            <strong>
                                Register a Merchant Account with OpenSupermall.com
                            </strong>
                            <div class="part-one-content-desc list">
                                <ul>
                                    <li> Fill up a merchant registration from (link)</li>
                                    <li> One of our Merchant Consultants will contact you to complete the registration process.</li>
                                    <li> if you are facing any problems, please do call out help line : <span>+6012-272 0667</span></li>
                                </ul>
                            </div>
                        </div><!-- part-one-content-heading end -->
                    </div><!-- part-one-content end -->

                    <div class="part-one-number">
                        <span>1</span>
                    </div><!-- part-one end -->

                    <div class="clearfix"></div>
                </div><!-- part-one-number end -->

                <div class="end-line">
                    <canvas id="end-line" width="150" height="16"></canvas>
                </div><!-- end-line -->

                <div class="part-two">
                    <div class="part-two-number">
                        <span>2</span>
                    </div><!-- part-two-number end -->

                    <div class="part-two-content">
                        <div class="part-two-content-heading">
                            <div class="part-two-content-desc">
                                <strong style="padding-bottom:10px"> After successful registration,login to your merchant profile</strong>
                            </div>
                        </div>
                    </div><!-- part-two-content end -->

                    <div class="part-two-image">
                        <img src="/images/computer.jpg" alt="Welcome">
                    </div><!-- part-two-image end -->
                    <div class="clearfix"></div>

                </div><!-- part-two end -->

                <div class="part-three">
                    <div class="part-three-line">
                        <canvas id="part-three" width="100" height="130"></canvas>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- part-three -->


                <div class="end-line">
                    <canvas id="end-line-1" width="150" height="16"></canvas>
                </div><!-- end-line -->


                <div class="part-four">
                    <div class="part-four-image">
                        <img src="/images/computer2.jpg" alt="Welcome">
                    </div><!-- part-four-image end -->

                    <div class="part-four-content">
                        <div class="part-four-content-heading">
                            <strong>
                                List your products
                            </strong>
                            <div class="part-four-content-desc desc-width-sell list">
                                <ul>
                                    <li> Describe your product and add photos.</li>
                                    <li> Choose the shipping option.</li>
                                    <li> Read the terms &amp; Conditions and agree. </li>
                                    <li> Read the Refund &amp; Refund policy and agree. </li>
                                </ul>
                            </div>
                        </div><!-- part-four-content-heading end -->
                    </div><!-- part-four-content end -->

                    <div class="part-four-number width-adjust">
                        <span>3</span>
                    </div><!-- part-four-number end -->

                    <div class="part-four-line">
                        <canvas id="part-four" width="200" height="250"></canvas>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- part-four-number end -->


                <div class="end-line">
                    <canvas id="end-line-2" width="150" height="16"></canvas>
                </div><!-- end-line -->

                <div class="part-five override-part-five">
                    <div class="part-five-number">
                        <span>4</span>
                    </div><!-- part-five-number end -->

                    <div class="part-five-content override-five-content">
                        <div class="part-five-content-heading">
                            <strong>
                                Check your orders
                            </strong>
                            <div class="part-five-content-desc list">
                                <ul>
                                    <li> Keep track of your confirmed orders </li>
                                    <li>by heading to order management.</li>
                                </ul>
                            </div>
                        </div><!-- part-five-content-heading end -->
                        <div class="clearfix"></div>
                    </div><!-- part-five-content end -->

                    <div class="part-five-image override-five-image">
                        <img src="/images/po.jpg" alt="Welcome">
                    </div><!-- part-five-image end -->

                    <div class="clearfix"></div>
                </div><!-- part-five-number end -->

                <div class="part-six">
                    <div class="part-six-line">
                        <canvas id="part-six" width="200" height="250"></canvas>
                    </div>
                </div><!-- part-six end -->

                <div class="end-line">
                    <canvas id="end-line-3" width="150" height="16"></canvas>
                </div><!-- end-line -->

                <div class="part-svn">
                    <div class="part-svn-image">
                        <img src="/images/transport.jpg" alt="Welcome">
                    </div><!-- part-svn-image end -->
                    <div class="part-svn-content">
                        <div class="part-svn-content-heading">
                            <strong>
                                Product delivery.
                            </strong>
                            <div class="part-svn-content-desc list">
                                <ul>
                                    <li> Pack you order and send them via the customer\'s preffred shipping option within 3 business days.</li>
                                    <li> Then update the product delivery status by keying in the tracking number and delivery service.</li>

                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- part-svn-content-heading end -->
                    </div><!-- part-svn-content end -->
                    <div class="part-svn-number">
                        <span>5</span>
                    </div><!-- part-svn-number end -->
                    <div class="clearfix"></div>
                </div><!-- part-svn-number end -->

                <div class="adjust">
                    <div class="part-eight">
                        <div class="part-eight-line">
                            <canvas id="part-eight" width="100" height="150"></canvas>
                        </div>
                    </div><!-- part-eight end -->
                </div>

                <div class="end-line">
                    <canvas id="end-line-4" width="150" height="16"></canvas>
                </div><!-- end-line -->

                <div class="part-nine">
                    <div class="part-nine-number">
                        <span>6</span>
                    </div><!-- part-nine-number end -->

                    <div class="part-nine-image">
                        <img src="/images/mail.jpg" alt="Welcome">
                    </div><!-- part-nine-image end -->

                    <div class="part-nine-content">
                        <div class="part-nine-content-heading">
                            <strong>
                                Product Receipt
                            </strong>
                            <div class="part-nine-content-desc">
                                <li> After completing the delivery process without any dispute / cancellation, you will receive the settlement to your registered bank account.</li>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- part-nine-content-heading end -->
                    </div><!-- part-nine-content end -->
                    <div class="clearfix"></div>
                </div><!-- part-nine-number end -->

                <div class="end-line">
                    <canvas id="end-line-5" width="150" height="16"></canvas>
                </div><!-- end-line -->
            </div><!-- sell-inage end -->
        </div><!-- container end -->
    </div><!-- content end -->
</section><!-- section content end -->
';
		$how_to_return = ' Pack you order and send them via the customer\'s preffred shipping option within 3 business days.
							> Then update the product delivery status by keying in the tracking number and delivery service.';

        \DB::table('fsection_a')->insert(array (
                'about_us' => $about_us,
                'private_policy' => $private_policy,
                'how_to_buy' => $how_to_buy,
                'how_to_return' => $how_to_return,
                'how_to_sell' => $how_to_sell,
                'terms_and_conditions' => $terms_and_conditions,
                'created_at' => $now,
                'updated_at' => $now,
            )
       );
    }
}
