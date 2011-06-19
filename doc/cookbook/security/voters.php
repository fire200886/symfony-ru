<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to implement your own Voter to blacklist IP Addresses</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-implement-your-own-voter-to-blacklist-ip-addresses">
      <span id="index-0"></span><h1>How to implement your own Voter to blacklist IP Addresses<a class="headerlink" href="#how-to-implement-your-own-voter-to-blacklist-ip-addresses" title="Permalink to this headline">¶</a></h1>
      <p>The Symfony2 security component provides several layers to authenticate users.
	One of the layers is called a <cite>voter</cite>. A voter is a dedicated class that checks
	if the user has the rights to be connected to the application. For instance,
	Symfony2 provides a layer that checks if the user is fully authenticated or if
	it has some expected roles.</p>
      <p>It is sometimes useful to create a custom voter to handle a specific case not
	handled by the framework. In this section, you'll learn how to create a voter
	that will allow you to blacklist users by their IP.</p>
      <div class="section" id="the-voter-interface">
	<h2>The Voter Interface<a class="headerlink" href="#the-voter-interface" title="Permalink to this headline">¶</a></h2>
	<p>A custom voter must implement
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Security/Core/Authorization/Voter/VoterInterface.html" title="Symfony\Component\Security\Core\Authorization\Voter\VoterInterface"><span class="pre">VoterInterface</span></a></tt>,
	  which requires the following three methods:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">interface</span> <span class="nx">VoterInterface</span>
<span class="p">{</span>
    <span class="k">function</span> <span class="nf">supportsAttribute</span><span class="p">(</span><span class="nv">$attribute</span><span class="p">);</span>
    <span class="k">function</span> <span class="nf">supportsClass</span><span class="p">(</span><span class="nv">$class</span><span class="p">);</span>
    <span class="k">function</span> <span class="nf">vote</span><span class="p">(</span><span class="nx">TokenInterface</span> <span class="nv">$token</span><span class="p">,</span> <span class="nv">$object</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$attributes</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">supportsAttribute()</span></tt> method is used to check if the voter supports
	  the given user attribute (i.e: a role, an acl, etc.).</p>
	<p>The <tt class="docutils literal"><span class="pre">supportsClass()</span></tt> method is used to check if the voter supports the
	  current user token class.</p>
	<p>The <tt class="docutils literal"><span class="pre">vote()</span></tt> method must implement the business logic that verifies whether
	  or not the user is granted access. This method must return one of the following
	  values:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">VoterInterface::ACCESS_GRANTED</span></tt>: The user is allowed to access the application</li>
	  <li><tt class="docutils literal"><span class="pre">VoterInterface::ACCESS_ABSTAIN</span></tt>: The voter cannot decide if the user is granted or not</li>
	  <li><tt class="docutils literal"><span class="pre">VoterInterface::ACCESS_DENIED</span></tt>: The user is not allowed to access the application</li>
	</ul>
	<p>In this example, we will check if the user's IP address matches against a list of
	  blacklisted addresses. If the user's IP is blacklisted, we will return
	  <tt class="docutils literal"><span class="pre">VoterInterface::ACCESS_DENIED</span></tt>, otherwise we will return
	  <tt class="docutils literal"><span class="pre">VoterInterface::ACCESS_ABSTAIN</span></tt> as this voter's purpose is only to deny
	  access, not to grant access.</p>
      </div>
      <div class="section" id="creating-a-custom-voter">
	<h2>Creating a Custom Voter<a class="headerlink" href="#creating-a-custom-voter" title="Permalink to this headline">¶</a></h2>
	<p>To blacklist a user based on its IP, we can use the <tt class="docutils literal"><span class="pre">request</span></tt> service
	  and compare the IP address against a set of blacklisted IP addresses:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\DemoBundle\Security\Authorization\Voter</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\Authorization\Voter\VoterInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\Authentication\Token\TokenInterface</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">ClientIpVoter</span> <span class="k">implements</span> <span class="nx">VoterInterface</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">Request</span> <span class="nv">$request</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$blacklistedIp</span> <span class="o">=</span> <span class="k">array</span><span class="p">())</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">request</span>       <span class="o">=</span> <span class="nv">$request</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">blacklistedIp</span> <span class="o">=</span> <span class="nv">$blacklistedIp</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">supportsAttribute</span><span class="p">(</span><span class="nv">$attribute</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// we won't check against a user attribute, so we return true</span>
        <span class="k">return</span> <span class="k">true</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">supportsClass</span><span class="p">(</span><span class="nv">$class</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// our voter supports all type of token classes, so we return true</span>
        <span class="k">return</span> <span class="k">true</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">function</span> <span class="nf">vote</span><span class="p">(</span><span class="nx">TokenInterface</span> <span class="nv">$token</span><span class="p">,</span> <span class="nv">$object</span><span class="p">,</span> <span class="k">array</span> <span class="nv">$attributes</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">if</span> <span class="p">(</span><span class="nb">in_array</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">request</span><span class="o">-&gt;</span><span class="na">getClientIp</span><span class="p">(),</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">blacklistedIp</span><span class="p">))</span> <span class="p">{</span>
            <span class="k">return</span> <span class="nx">VoterInterface</span><span class="o">::</span><span class="na">ACCESS_DENIED</span><span class="p">;</span>
        <span class="p">}</span>

        <span class="k">return</span> <span class="nx">VoterInterface</span><span class="o">::</span><span class="na">ACCESS_ABSTAIN</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>That's it! The voter is done. The next step is to inject the voter into
	  the security layer. This can be done easily through the service container.</p>
      </div>
      <div class="section" id="declaring-the-voter-as-a-service">
	<h2>Declaring the Voter as a Service<a class="headerlink" href="#declaring-the-voter-as-a-service" title="Permalink to this headline">¶</a></h2>
	<p>To inject the voter into the security layer, we must declare it as a service,
	  and tag it as a "security.voter":</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 220px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/AcmeBundle/Resources/config/services.yml

services:
    security.access.blacklist_voter:
        class:      Acme\DemoBundle\Security\Authorization\Voter\ClientIpVoter
        arguments:  [@request, [123.123.123.123, 171.171.171.171]]
        public:     false
        tags:
		  -       { name: security.voter }</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/AcmeBundle/Resources/config/services.xml --&gt;</span>

<span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"security.access.blacklist_voter"</span>
         <span class="na">class=</span><span class="s">"Acme\DemoBundle\Security\Authorization\Voter\ClientIpVoter"</span> <span class="na">public=</span><span class="s">"false"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"request"</span> <span class="na">strict=</span><span class="s">"false"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"collection"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;argument&gt;</span>123.123.123.123<span class="nt">&lt;/argument&gt;</span>
        <span class="nt">&lt;argument&gt;</span>171.171.171.171<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"security.voter"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/AcmeBundle/Resources/config/services.php</span>

<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'Acme\DemoBundle\Security\Authorization\Voter\ClientIpVoter'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span>
        <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'request'</span><span class="p">),</span>
        <span class="k">array</span><span class="p">(</span><span class="s1">'123.123.123.123'</span><span class="p">,</span> <span class="s1">'171.171.171.171'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">);</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'security.voter'</span><span class="p">);</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">setPublic</span><span class="p">(</span><span class="k">false</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'security.access.blacklist_voter'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Be sure to import this configuration file from your main application
	      configuration file (e.g. <tt class="docutils literal"><span class="pre">app/config/config.yml</span></tt>). For more information
	      see <a class="reference internal" href="../../book/service_container.html#service-container-imports-directive"><em>Importing Configuration with imports</em></a>. To read more about defining
	      services in general, see the <a class="reference internal" href="../../book/service_container.html"><em>Service Container</em></a> chapter.</p>
	</div></div>
      </div>
      <div class="section" id="changing-the-access-decision-strategy">
	<h2>Changing the Access Decision Strategy<a class="headerlink" href="#changing-the-access-decision-strategy" title="Permalink to this headline">¶</a></h2>
	<p>In order for the new voter to take effect, we need to change the default access
	  decision strategy, which, by default, grants access if <em>any</em> voter grants
	  access.</p>
	<p>In our case, we will choose the <tt class="docutils literal"><span class="pre">unanimous</span></tt> strategy. Unlike the <tt class="docutils literal"><span class="pre">affirmative</span></tt>
	  strategy (the default), with the <tt class="docutils literal"><span class="pre">unanimous</span></tt> strategy, if only one voter
	  denies access (e.g. the <tt class="docutils literal"><span class="pre">ClientIpVoter</span></tt>), access is not granted to the
	  end user.</p>
	<p>To do that, override the default <tt class="docutils literal"><span class="pre">access_decision_manager</span></tt> section of your
	  application configuration file with the following code.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">access_decision_manager</span><span class="p-Indicator">:</span>
        <span class="c1"># Strategy can be: affirmative, unanimous or consensus</span>
        <span class="l-Scalar-Plain">strategy</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">unanimous</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>That's it! Now, when deciding whether or not a user should have access,
	  the new voter will deny access to any user in the list of blacklisted IPs.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to add &quot;Remember Me&quot; Login Functionality" href="remember_me.html">
      «&nbsp;How to add "Remember Me" Login Functionality
    </a><span class="separator">|</span>
    <a accesskey="N" title="Access Control Lists (ACLs)" href="acl.html">
      Access Control Lists (ACLs)&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
