@extends('common.default')
@section('content')


<style>
    .has-error .form-control {
        border-color: #a94442;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    }

</style>
<div class="container">
    <div class="row" style="margin-top:-15px;">
        {!! Form::open(array('method'=>'POST','url'=>'privacy','class'=>'form-horizontal', "id"=>"register-form")) !!}
        {!! $content !!}
 <!--        <div class="panel panel-default">
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
                    to claims that a listing or other content violates the rights of others, or protect anyone's rights,
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
                    criminal or civil wrongdoing. Further, Company may disclose the User's identify and contact
                    information, or such other transaction-related data, if requested by a government or law enforcement
                    body, private investigator, rightful owner or interest holder and/or any injured third party or as a
                    result of a subpoena or other legal action, or if Company is of the view, in its sole and absolute
                    discretion, that it would be in its best interest to do so. Company shall not be liable for damages
                    or results arising from such disclosure, and the User(s) agrees not to bring action or claim against
                    Company for such disclosure.</p>
                <h3>Using Information from this Website</h3>
                <p>We enable you to share personal information to complete transactions. When users are involved in a
                    transaction, they may have access to each other's name, user ID, email address and other contact and
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
        </div> -->

    </div>
</div>

{!! Form::close() !!}
@stop
