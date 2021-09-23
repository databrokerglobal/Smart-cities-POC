@extends('layouts.app')

@section('title', 'Terms and conditions | Databroker')

@section('content')       
<div class="container-fluid app-wapper bg-pattern-side app-wapper-privacy-policy">
    <div class="container">
        <div class="mt-30">
            <h1 class="text-primary text-center text-bold">{{ trans('about.terms_conditions') }}</h1>
            <p class="fs-20 lh-30 text-center text-bold">CONDITIONS RELATED TO THE CONTRACTUAL OBLIGATIONS FOR USING THE <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> SITE AS DATA PROVIDER</p>
            <div class="row">
            	<div class="col-md-12">
            		<div class="mt-50">
	            		<h2 class="text-bold text-uppercase mb-20">{{ trans('about.preamble')}}</h2>
	            		<p class="fs-18 lh-27"><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is the owner and operator of a platform below called "site" to promote Data Offers and Data Products of Data Provider. The Data Provider is interested in the services of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and wants to use the platform to promote its Data Offers and Data Products over the internet. The Data Products  will be presented, and some offered for sale to users (hereinafter referred as "Customers") who will visit the site and will, according to their wish, do the purchase of the Data Product(s) from the Data Provider (hereinafter referred as “Data Provider”).</p>
	            	</div>
            		<div class="mt-50">
	            		<h2 class="text-bold text-uppercase mb-20">{{ trans('about.definitions')}}</h2>
	            		<p class="fs-18 lh-27"><b>Data Provider : </b> the user placing Data Offers and/or Data Products on the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site.</p>
	            		<p class="fs-18 lh-27"><b>Data Offer : </b> any information in relation to the services provided by the Data Provider.</p>
	            		<p class="fs-18 lh-27"><b>Data Product :</b> any type and format of data provided by the Data Provider and available for Customers to order on the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site.</p>
						<p class="fs-18 lh-27"><b>Data Publisher :</b> the user that facilitates the collection, hosting and
						 sharing of Data Offers and Data Products on <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site for the account of the Data Provider; 
						 </p>
						<p class="fs-18 lh-27"><b>Customer :</b> a user of the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site interested in the Data Offer(s) or Data Product(s) of a Data Provider. </p>
						<p class="fs-18 lh-27"><b>Personal Data :</b> any and all information concerning an identified or identifiable natural person.</p>
						<p class="fs-18 lh-27"><b>Price :</b> the sales price of a Data Product encoded by a Data Provider on the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site.</p>
						<p class="fs-18 lh-27"><b>Deal :</b> any Data Product sold to a Customer through the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site.</p>
						<p class="fs-18 lh-27"><b>DXC (Data Exchange Controller) :</b> a <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> developed and owned software, provided as a service to Data Provider for delivering Data Products to Customers;</p>
						<p class="fs-18 lh-27"><b>Commission:</b>any amount received by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> for using the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> services.</p>
						<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}1 : {{ trans('about.object')}}</h3>
		            		<p class="fs-18 lh-27">This agreement aims to define the contractual relationships between <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and the Data Provider and the conditions applicable to any purchase made by Customers, through the site of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> (<a href="https://www.<span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>.global">www.<span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>.global</a> ) or all associated site, whether the Customer being a professional or consumer. The sale of a Data Product through the site implies unreserved acceptance by the Data Provider of the provisions of this agreement. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and his site uses trademarks which are the property of SettleMint NV and/or its leaders. The Head Office of SettleMint NV is located to Arnould Nobelstraat 38, 3000 LEUVEN (Belgium), Reg BE 0661.674.810. Any reference to <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> concerns only the rights and obligations of SettleMint NV. If <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> does not invoke a provision of the present contract at any given time, it can never be interpreted as a renunciation on its part to use later. This Agreement essentially concerns the relationship between the Data Provider of Data Products on the site(s) of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> has no contractual relationship with clients, which only contract with the Data Provider. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> does promote the Data Products of the Data Provider on the Internet. The Data Provider has perfect knowledge of the general sales conditions of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>. The Data Provider undertakes that its own terms are not in contradiction with those of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and comply with the legal provisions and the case law. </p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}2 : {{ trans('about.characteristics_of_data_products')}}</h3>
		            		<div class="mt-20">
			            		<p class="fs-18 lh-27 text-bold">2.1 - sales of data to Customers through the site of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span></p>
			            		<p class="fs-18 lh-27">Data Product can be ordered by a Customer as soon as the Data Provider has a well running and configured DXC (Data Exchange Controller) software. Data Product listed on the site is accompanied by a description established by the Data Provider. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is not responsible for any differences between the Data Product and the description given by the Data Provider. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> cannot be considered as a vendor of products on its site. The role of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is to present the Data Product and to bring the Customer in contact with the Data Provider which is assuming full liability for the sale and its consequences. The Data Provider will at all times ensure that the descriptions of its Data Products match perfectly with the reality. Once a Deal is done between the Data Provider and the Customer, the Data Product must be delivered in the state it was described on the site, by use of the DXC software. The Data Provider will only offer Data Products, original, and not falsified, respecting the intellectual property of those who hold, whose sale is legal, respect morality and regulation in place, including compliance to the GDPR regulation. It is, moreover, strictly forbidden to sell on <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> Data Products containing pornographic, illegal data or data causing a potential threat to the data users. The Data Provider will ensure that its own terms of conditions and terms of use of Data Products are accessible and visible by Customers. The Data Provider shall be solely responsible for the legality of its conditions of sale. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> reserves, moreover, the right to refuse any Data Product for sale on its site, without having to justify its decision. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> reserves its rights to immediately remove, without notice or compensation to the Data Provider, all Data Offer and Data Product published by the Data Provider on the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site in case the Data Provider does not respect the conditions of the present contract.</p>
			            	</div>
		            		<div class="mt-20">
			            		<p class="fs-18 lh-27 text-bold">2.2 - other services offered by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and/or Data Publishers to Data Providers</p>
			            		<p class="fs-18 lh-27"><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and/or Data Publishers 
								 may propose other services to the Data Provider i.e. the promotion of Data Products on the site, “DXC” hosting services, integration services with 3rd party applications. 
								 Unless otherwise stated, these services are ordered via the administration interface 
								 to which the Data Provider has access to the site of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>, and delivered as soon as payment is received by the Data Provider. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will make every effort to ensure the continuity of these services, but cannot be held responsible for the failure (delay, interruption of service...) to provide these services to the Data Provider.</p>
			            	</div>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}3 : {{ trans('about.rates')}}, {{ trans('about.taxes')}}</h3>
		            		<p class="fs-18 lh-27">Prices for Data Products are listed in euros, all taxes and VAT included. The Price of the Data Product published at the time of a Deal will be the one applicable to the Customer and for the Commission calculation (see Article 6 – Payment Terms). At the request of the Customer, the Data Provider will establish an invoice showing the VAT information applicable to the Customer’s country and organization. The Data Provider authorizes optionally <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> to generate invoices in the name and for the account of the Data Provider.</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}4 : {{ trans('about.orders')}}</h3>
		            		<p class="fs-18 lh-27">The Customer who wishes to close a Deal, purchase a Data Product from the Data Provider, must: </p>
		            		<ul class="fs-18 lh-27 pl-20 list-style-none">
		            			<li>- fill the form of identification on which it will indicate all requested details or give his Customer number if it has one;</li>
		            			<li>- fill out the order form online by giving all the references of the Data Product and options;</li>
		            			<li>- validate the order after having checked it;</li>
		            			<li>- read, accept and validate the Data Provider terms;</li>
		            			<li>- confirm his order by clicking the “BUY” button</li>
		            			<li>- make payment under the conditions laid down</li>
		            			<li>- if required, provide supplementary technical information to access the Data Products;</li>
		            		</ul>
		            		<p class="fs-18 lh-27">The order confirmation leads to acceptance of the terms and conditions of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and the Data Provider, the confirmation of knowledge and the waiver of its own conditions of purchase or other conditions. All of the data supplied by the Data Provider and recorded payment shall be evidence of the transaction. The confirmation will be worth signature and acceptance of the transaction performed. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> communicate to the Customer by e-mail and/or by its administration interface the recorded order confirmation and receipt of payment. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will immediately communicate the purchase to the Data Provider, who agrees to deliver the order immediately. The Data Provider is not allowed to deliver the Data Product before <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> confirmed the order receipt and payment from the buyer.</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}5 : {{ trans('about.dispute')}}, {{ trans('about.arbitration')}}</h3>
		            		<p class="fs-18 lh-27">The Customer enjoys a warranty period of thirty days from the receipt of the order. During this period, the Customer can complain to <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> for non-reception or non-compliance of the Data Product from the Data Provider.</p>
		            		<p class="fs-18 lh-27">
							In case of dispute, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will act as arbitrator and aim to provide a neutral and cost-effective means of resolving the dispute quickly between the Customer and the Data Provider. Arbitration is more informal than a lawsuit in court.  Arbitration uses a neutral arbitrator instead of a judge or jury, and court review of an arbitration award is very limited. As a result, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> might decide to cancel the order, partly or fully refund the Customer.
							</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}6 : {{ trans('about.payment_terms')}}</h3>
		            		<p class="fs-18 lh-27">Electronic payments will be made by the Customer exclusively by credit card or by any other means accepted by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>. The electronic payments will be made through a secure system which uses protocol SSL (Secure Socket Layer) so that the transmitted information is encrypted by a software and that no third party can take knowledge of the financial transaction. The Data Provider gives, by signing this contract, explicit authorization to <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> to collect the price of all transactions on his behalf and convert it to an equivalent digital currency token “DTX” (DaTa eXchange :  <a href="#">CoinMarketCap</a>) according the market value at the time of the transaction. Within 30 days following the payment reception from the Customer, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will transfer the amount of DTX to the Data Provider wallet, 
							deducted with a Commission of 10% tax included applied on the total amount of sales. 
							A supplementary commission could be applied according to the terms preliminary agreed between the Data Provider and his preferred Data Publisher.
							
							</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}7 : {{ trans('about.liability')}}</h3>
		            		<p class="fs-18 lh-27"><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>, in the process of online selling, is bound by an obligation of means and not results; its responsibility could not be committed for a damage resulting from the use of Internet network such as loss of data, intrusion, virus, service disruption, or other involuntary problems. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> cannot be responsible for a breach of Data Product delivery of the Data Provider. The Data Provider assumes the full liability related to the Data Product he offers for sale on the site of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>. The Data Provider will hold free <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> of any claim of Customers or third parties, relating to the Data Product offered by the Data Provider, regardless of the nature or the subject of the complaint. The Data Provider will ensure at all times that its terms and conditions and business practices conform to the law.</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}8 : {{ trans('about.intellectual_property')}}</h3>
		            		<p class="fs-18 lh-27">All elements of the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site are and remain the intellectual and exclusive property of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>. No one is allowed to reproduce, exploit, repeat, or use in any capacity whatsoever, even partially, elements of the site, software, visual or sound. Any reference to <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> to external is strictly forbidden without an express written and prior agreement of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>.</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}9 : {{ trans('about.personal_data')}}</h3>
		            		<p class="fs-18 lh-27">In accordance with the law, to personal information about Customers will be able to subject to automated treatment. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> reserves the right to collect information about the Customers, including by using cookies, exclusively for the purpose of promotion of its activities, the Data Providers and their Data Products. Customers can oppose the disclosure of their details by pointing it to <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>. Similarly, users have a right to access and rectify the data concerning them, by sending a registered letter with acknowledgment of receipt to Settlemint nv, Arnould Nobelstraat 38, 3000 LEUVEN (Belgium). The Data Provider has no access right to the Customers related data on the <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> site, with the exception of data needed for sale and billing. The ' Annex A ' to this contract defines the conditions for the processing of data between <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> and Data Provider and more particularly towards GDPR (General Data Protection Regulation).</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}10 : {{ trans('about.archiving_proof')}}</h3>
		            		<p class="fs-18 lh-27"><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> archived purchase orders and invoices on a reliable and durable support constituting a copy faithful. The computerized registers of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will be considered by the parties as proof of communications, orders, payments and transactions occurred between the Customer and the Data Provider.</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}11 : {{ trans('about.duration')}} - {{ trans('about.termination')}} - {{trans('about.sanctions')}}</h3>
		            		<p class="fs-18 lh-27">The present contract is concluded for a period of one year from the date of its signature. He will be tacitly renewed for periods of one year, unless notice notified by one party to the other party by registered letter, 3 months at least before the contractual deadline. It may be terminated immediately, without notice or compensation, in the event that a party does not respect commitments made under this agreement. From termination of the contract, regardless of the cause, or for non-payment of the amounts due, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> may withdraw temporarily or permanently from its site any mention about the Data Provider, as well as all the items of the latter. The Data Provider will remain nevertheless bound to all the commitments made, particularly with respect to buyers.</p>
		            		<p class="fs-18 lh-27">Except in case of fault, any termination contract terminated will continue to produce its effects until the end of the ongoing contractual period. At all times, the Data Provider will ensure <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> of any remedy exercised against <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> by a Customer, and will indemnify <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> any damage then a fault or a liability of the Data Provider.</p>
		            	</div>
		            	<div class="mt-30">
		            		<h3 class="text-bold text-uppercase">{{ trans('about.article') }}12 : {{ trans('about.applicable_law')}} - {{ trans('about.disputes')}}</h3>
		            		<p class="fs-18 lh-27">The english text of these general conditions will be only between parties. The text communicated to the Customer in a language other than English (on the website or by any other means) is transmitted as strictly commercial and informative.</p>
		            		<p class="fs-18 lh-27">The present contract is subject to Belgian law. The parties agree that any disagreement or dispute relating to this agreement or arising out of its interpretation or its application will be submitted to mediation, without prejudice to any possible measures. To this effect, the parties hereto agree to participate at a mediation meeting delegating a person with decision-making power. The Chartered mediator will be chosen by the parties among the mediators approved by the SPF Justice (Belgian Ministry of Justice). Failing amicable agreement, any dispute under execution or interpretation of this agreement will be of the exclusive competence of the courts of the judicial arrondissement of Brussels (Belgium), regardless of the domicile or headquarters of the Data Provider.</p>
		            	</div>
	            	</div>
            	</div>
            </div>
        </div>
        <div class="mt-50">
        	<h1 class="text-primary text-center text-bold">{{ trans('about.general_sales_conditions') }} - ANNEX A</h1>
            <p class="fs-20 lh-30 text-center text-bold">CONDITIONS RELATED TO THE PROCESSING OF PERSONAL DATA AND GENERAL DATA PROTECTION REGULATION (GDPR)</p>
            <div class="row">
            	<div class="col-md-12">
            		<div class="mt-50">
	            		<h2 class="text-bold text-uppercase mb-20">{{ trans('about.preamble')}}</h2>
	            		<p class="fs-18 lh-27">The Data Provider and <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> are bound by one or more contract (s) involving <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> of data treatment personal data on behalf of the Data Provider. The Data Provider and <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> wish to ensure that relevant policies include appropriate conditions to ensure that compliance with the respective obligations of the parties in the protection of data. The objective of this agreement is to define certain conditions to be applied to the treatment of the personal data.</p>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.1: {{ trans('about.definitions')}}</h3>
		            		<p class="fs-18 lh-27">Terms used in this article concerning the treatment of data:</p>
		            		<ul class="fs-18 lh-27 pl-20 list-style-none">
		            			<li>-"The data protection regulation": all the laws applicable to personal data processed as part of the contract or in connection with it, including Directive 95/46/EC on the protection of individuals physical for the data processing to personal data and the free movement of such data (such as that can be replaced by the GDPR); the Directive 2002/58/EC concerning the processing of personal data and the protection of privacy in the sector of electronic communications (directive privacy and electronic communications); the GDPR, after its entry into force; the law of 8 December 1992 on the protection of privacy with respect to the treatment of personal data and all other national laws putting implementing or supplementing one any of those provisions; and all associated codes of practice and all the other guidelines binding published by any regulatory body; all such as modified, can and/or replaced and in force at any time;</li>
		            			<li>- 'ALACK": defined in article A.8 (g) (ii) (C) below</li>
		            			<li>- 'GDPR': the regulation 2016/679 on the protection of natural persons with respect to the processing of personal data and the free movement of such data, and repealing the directive 95/46/EC (General regulations on the Protection of data).</li>
		            			<li>- "Conditions": defined in article A.8 (g) (ii) (C) below;</li>
		            			<li>- ' Services': all services to be provided under the contract / contracts</li>
		            		</ul>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.2: {{ trans('about.terms_of_regulation')}}</h3>
		            		<p class="fs-18 lh-27">When used in this clause relating to the processing of data, the following terms shall have the same meaning as in regulation of Data Protection:</p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>personal data; </li>
		            			<li>the controller; </li>
		            			<li>subcontractor; </li>
		            			<li>treatment; and </li>
		            			<li>supervisory authority. </li>
		            		</ul>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.3: {{ trans('about.relationship_and_role_of_the_parties')}}</h3>
		            		<p class="fs-18 lh-27">With respect to the treatment of the personal data under this agreement, the parties acknowledge and agree to the fact that: </p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>the Data Provider is responsible for the treatment; and</li>
		            			<li><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is the subcontractor.</li>
		            		</ul>
		            		<p class="fs-18 lh-27 text-italic"><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> accepts and processes the personal data in accordance with the terms of this agreement</p>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.4: {{ trans('about.context')}}</h3>
		            		<p class="fs-18 lh-27">Under the agreement, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> can provide Services related to one or more of the following activities:</p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>the publication and imaging;</li>
		            			<li>communication;</li>
		            			<li>the treatment and management of documents;</li>
		            			<li>support and maintenance;</li>
		            			<li>the operation and management of business processes. and/or</li>
		            			<li>the allocation of resources;</li>
		            		</ul>
		            		<p class="fs-18 lh-27">as agreed, upon in detail from time to time between the Data Provider and <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>. This may involve the processing of personal data by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> on behalf of the Data Provider under the provision of the Services concerned, including Data Providers or to personnel of the Data Provider or other personal data people with whom the Data Provider deals in its activities (such as that can be described in more detail in this Agreement).</p>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.5: {{ trans('about.description_of_the_treatment')}}</h3>
		            		<p class="fs-18 lh-27">The treatment to be performed by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is as follows:</p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>the purpose of the treatment is as described in section 1.4 above and the duration of the treatment will correspond to the entire period during which <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> runs the Services under this agreement;</li>
		            			<li>the nature of the treatment is described in section 1.4 above and the purpose of the processing is to allow <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> to perform Services under this agreement;</li>
		            			<li>to treat personal data will be all the personal data requested by the Data Provider in order to allow or facilitate the provision of Services by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> under this agreement, as described in section 1.4 above, and the categories of persons concerned are described in Article A.4 above; and</li>
		            			<li>the obligations and rights of the controller in the treatment are set out below.</li>
		            		</ul>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.6: {{ trans('about.compliance_has_regulatory')}}</h3>
		            		<p class="fs-18 lh-27">The Data Provider and <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will comply (and shall ensure that their staff and/or their subcontractors comply) to the data protection regulations.</p>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.7: {{ trans('about.people_managers_and_enquiries')}}</h3>
		            		<p class="fs-18 lh-27">The Data Provider and <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> shall notify each other the person within their organization who is authorized to respond to enquiries concerning the personal data and the treatment that is the subject of this agreement from time to time. The Data Provider and <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will have to process these applications quickly and reasonably.</p>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.8: {{ trans('about.treatment_of_data_by_databroker')}}</h3>
		            		<p class="fs-18 lh-27">With respect to the treatment of the personal data under this agreement, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will have to:</p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>
		            				<p class="fs-18 lh-27">treat the personal data (including during an international transfer of the personal data) only to the extent necessary to provide the Services and only in accordance with:</p>
		            				<ul class="list-style-lower-roman">
		            					<li>the terms of this agreement</li>
		            					<li>
		            						the written instructions of the Data Provider from time to time;
											unless otherwise provided by law. If <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is required by law to treat the personal data other than in accordance with what was provided for in the framework of this agreement, it will inform the Data Provider prior to the treatment in question (unless the law prevents <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> do it for important reasons of public interest)
										</li>
		            				</ul>
		            			</li>
		            			<li>to implement technical and organizational measures appropriate to ensure a level of security appropriate to the risks presented by the processing, including the protection against accidental or unlawful destruction, loss, modification, the unauthorized disclosure or unauthorized access to the personal data transmitted, stored or otherwise processed under this agreement;</li>
		            			<li>take all reasonable steps to ensure that only authorized staff has access to the personal data and any person authorized to access the personal data will respect and maintain the due confidentiality in which concerns the personal data (including through an obligation of confidentiality when the persons concerned are not subject to this obligation under the law);</li>
		            			<li>not take subsequent subcontractors in the execution of the Services without the prior written consent of the Data Provider and otherwise in accordance with article A.9, and this at any time.</li>
		            			<li>not do or omit to do anything which would have the effect of placing the Data Provider in breach of its obligations under the Data Protection regulation;</li>
		            			<li>immediately notify the Data Provider if, in the opinion of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>, any instruction given to <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> violated Data Protection regulation;</li>
		            			<li>
		            				<p class="fs-18 lh-27">if any, with respect to all data to personal data processed as part of the agreement, cooperate with the Data Provider and assist him to ensure compliance with:</p>
		            				<ul class="list-style-lower-roman">
		            					<li>the obligations of the Data Provider to meet the demands of any person seeking to exercise his rights under Chapter III of the GDPR, including by giving notice to the Data Provider any written request for access received by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> relating to the obligations of the Data Provider in respect of the regulation of the protection of data; and</li>
		            					<li>
		            						<p class="fs-18 lh-27">the obligations of the Data Provider under sections 32a 36 of the GDPR to:</p>
		            						<ul class="list-style-upper-alpha">
		            							<li>ensure the safety of the treatment</li>
		            							<li>notify the competent control authority and any person concerned, as appropriate, any violation of the personal data;</li>
		            							<li>conduct impact assessments relating to the protection of data (data protection impact assessment) (hereinafter a ' ALACK"); and</li>
		            							<li>ensure the safety of the treatmentconsult the authority of control prior to treatment when an iniquitous ALACK the treatment would entail a risk high in the absence of measures taken by the Data Provider to mitigate the risk.</li>
		            						</ul>
		            					</li>
		            				</ul>
		            			</li>
		            		</ul>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.9: {{ trans('about.subcontractors')}}</h3>
		            		<p class="fs-18 lh-27"><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will ensure that any subcontractor later that it committed to provide all services on its behalf under this agreement does only on the basis of a written contract that imposes such subsequent subcontractors of the conditions equivalent to those imposed by <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> in this annex or other alternative conditions that may be agreed upon with the Data Provider (the "applicable requirements"). <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> should ensure enforcement by the subsequent subcontractor of the applicable Conditions and will be directly responsible to the Data Provider for: </p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>any breach by the subsequent subcontractor one any of the applicable Conditions; </li>
		            			<li>
		            				<p class="fs-18 lh-27">any act or omission of the subsequent subcontractor as a result</p>
		            				<ul class="list-style-lower-roman">
		            					<li>to place <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> in breach of this agreement; or </li>
		            					<li>to place the Data Provider or <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> in breach of the data protection regulation. </li>
		            				</ul>
		            			</li>
		            		</ul>
		            		<p class="fs-18 lh-27">When the Data Provider gave <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> a general authorization to hire subcontractors later, before hiring a new subsequent subcontractor under I' general authorization, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> will inform the Data Provider of any changes made and give the Data Provider the opportunity to oppose.</p>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.10: {{ trans('about.monitoring_of_the_conformity_of_databroker')}}</h3>
		            		<p class="fs-18 lh-27">The Data Provider has the right to control and verify the compliance of <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> with the Data Protection Regulations and with his treatment obligations data under this agreement at any time during regular hours opening. <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is committed to provide to the Data Provider all access, assistance and information reasonably necessary to allow the checks and inspections concerned. If the Data Provider believes that an on-site audit is necessary, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> agrees to give the Data Provider a reasonable access to its premises (subject to reasonable confidentiality and security) and all the personal data stored so all programs of treatment of data on site. The Data Provider has the right to perform the audit by a third party. </p>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.11: {{ trans('about.transfer_outside_the_eea_and_third_parties')}}</h3>
		            		<p class="fs-18 lh-27">If <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> transfer all personal data received from the vendor or on his behalf:</p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>outside the European economic area; or</li>
		            			<li>
		            				to a third party, if the third party is located outside the European economic area; 
									<span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> shall, prior to any transfer, ask the Data Provider's written instructions.
								</li>
		            		</ul>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-uppercase mb-20">{{trans('about.article')}}A.12: {{ trans('about.end_of_service_delivery')}}</h3>
		            		<p class="fs-18 lh-27">At the end of the provision of Services, <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> shall, at the discretion of the Data Provider:</p>
		            		<ul class="fs-18 lh-27 list-style-lower-alpha">
		            			<li>delete; or</li>
		            			<li>return it to the Data Provider;</li>
		            		</ul>
		            		<p class="fs-18 lh-27">all data (including copies) personal data processed under this agreement, unless <span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> is legally required to keep copies of them.</p>
		            	</div>
	            		<div class="mt-30">
		            		<p class="fs-18 lh-27 text-center">*	*	 *</p>
		            	</div>
	            		<div class="mt-30">
		            		<h3 class="text-bold text-center">THESE CONDITIONS RELATING TO THE PROCESSING OF THE DATA</h3>
		            		<h3 class="text-bold text-center">ARE THE EXCLUSIVE PROPERTY OF:</h3>
		            	</div>
	            		<div class="mt-30">
		            		<p class="fs-18 lh-27 text-center"><span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span> Address</p>
		            		<p class="fs-18 lh-27 text-center">38 ARNOULD NOBELSTRAAT – 3000 LEUVEN – BELGIUM</p>
		            		<p class="fs-18 lh-27 text-center">COMPANY REGISTRATION  BE 0661.674.810</p>
		            		<p class="fs-18 lh-27 text-center">MAIL: <a href="#">HELLO@<span style='text-transform: uppercase;'>{{env("APP_NAME")}}</span>.GLOBAL</a></p>		            		
		            	</div>
		            </div>
            	</div>
            </div>
        </div>
    </div>
</div>
@endsection