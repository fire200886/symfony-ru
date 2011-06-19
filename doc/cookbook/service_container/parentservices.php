<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to Manage Common Dependencies with Parent Services</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-manage-common-dependencies-with-parent-services">
      <h1>How to Manage Common Dependencies with Parent Services<a class="headerlink" href="#how-to-manage-common-dependencies-with-parent-services" title="Permalink to this headline">¶</a></h1>
      <p>As you add more functionality to your application, you may well start to have
	related classes that share some of the same dependencies. For example you
	may have a Newsletter Manager which uses setter injection to set its dependencies:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Mail</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Acme\HelloBundle\Mailer</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\EmailFormatter</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$emailFormatter</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setMailer</span><span class="p">(</span><span class="nx">Mailer</span> <span class="nv">$mailer</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setEmailFormatter</span><span class="p">(</span><span class="nx">EmailFormatter</span> <span class="nv">$emailFormatter</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>and also a Greeting Card class which shares the same dependencies:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Mail</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Acme\HelloBundle\Mailer</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\EmailFormatter</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">GreetingCardManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$emailFormatter</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setMailer</span><span class="p">(</span><span class="nx">Mailer</span> <span class="nv">$mailer</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setEmailFormatter</span><span class="p">(</span><span class="nx">EmailFormatter</span> <span class="nv">$emailFormatter</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>The service config for these classes would look something like this:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 436px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Mail\NewsletterManager
    greeting_card_manager.class: Acme\HelloBundle\Mail\GreetingCardManager
services:
    my_mailer:
        # ...
    my_email_formatter:
        # ...
    newsletter_manager:
        class:     %newsletter_manager.class%
        calls:
            - [ setMailer, [ @my_mailer ] ]
            - [ setEmailFormatter, [ @my_email_formatter] ]

    greeting_card_manager:
        class:     %greeting_card_manager.class%
        calls:
            - [ setMailer, [ @my_mailer ] ]
		- [ setEmailFormatter, [ @my_email_formatter] ]</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;
&lt;parameters&gt;
    &lt;!-- ... --&gt;
    &lt;parameter key="newsletter_manager.class"&gt;Acme\HelloBundle\Mail\NewsletterManager&lt;/parameter&gt;
    &lt;parameter key="greeting_card_manager.class"&gt;Acme\HelloBundle\Mail\GreetingCardManager&lt;/parameter&gt;
&lt;/parameters&gt;

&lt;services&gt;
    &lt;service id="my_mailer" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="my_email_formatter" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="newsletter_manager" class="%newsletter_manager.class%"&gt;
        &lt;call method="setMailer"&gt;
             &lt;argument type="service" id="my_mailer" /&gt;
        &lt;/call&gt;
        &lt;call method="setEmailFormatter"&gt;
             &lt;argument type="service" id="my_email_formatter" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
    &lt;service id="greeting_card_manager" class="%greeting_card_manager.class%"&gt;
        &lt;call method="setMailer"&gt;
             &lt;argument type="service" id="my_mailer" /&gt;
        &lt;/call&gt;
        &lt;call method="setEmailFormatter"&gt;
             &lt;argument type="service" id="my_email_formatter" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
		&lt;/services&gt;</pre>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\NewsletterManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'greeting_card_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\GreetingCardManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_email_formatter'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setMailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">)</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setEmailFormatter'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_email_formatter'</span><span class="p">)</span>
<span class="p">));</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'greeting_card_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%greeting_card_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setMailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">)</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setEmailFormatter'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_email_formatter'</span><span class="p">)</span>
<span class="p">));</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>There is a lot of repetition in both the classes and the configuration. This
	means that if you changed, for example, the <tt class="docutils literal"><span class="pre">Mailer</span></tt> of <tt class="docutils literal"><span class="pre">EmailFormatter</span></tt>
	classes to be injected via the constructor, you would need to update the config
	in two places. Likewise if you needed to make changes to the setter methods
	you would need to do this in both classes. The typical way to deal with the
	common methods of these related classes would be to extract them to a super class:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Mail</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Acme\HelloBundle\Mailer</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\EmailFormatter</span><span class="p">;</span>

<span class="k">abstract</span> <span class="k">class</span> <span class="nc">MailManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$emailFormatter</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setMailer</span><span class="p">(</span><span class="nx">Mailer</span> <span class="nv">$mailer</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setEmailFormatter</span><span class="p">(</span><span class="nx">EmailFormatter</span> <span class="nv">$emailFormatter</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">mailer</span> <span class="o">=</span> <span class="nv">$mailer</span><span class="p">;</span>
    <span class="p">}</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>The <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt> and <tt class="docutils literal"><span class="pre">GreetingCardManager</span></tt> can then extend this
	super class:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Mail</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span> <span class="k">extends</span> <span class="nx">MailManager</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>and:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Mail</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">GreetingCardManager</span> <span class="k">extends</span> <span class="nx">MailManager</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>In a similar fashion, the Symfony2 service container also supports extending
	services in the configuration so you can also reduce the repetition by specifying
	a parent for a service.</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 508px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Mail\NewsletterManager
    greeting_card_manager.class: Acme\HelloBundle\Mail\GreetingCardManager
    mail_manager.class: Acme\HelloBundle\Mail\MailManager
services:
    my_mailer:
        # ...
    my_email_formatter:
        # ...
    mail_manager:
        class:     %mail_manager.class%
        abstract:  true
        calls:
            - [ setMailer, [ @my_mailer ] ]
            - [ setEmailFormatter, [ @my_email_formatter] ]

    newsletter_manager:
        class:     %newsletter_manager.class%
        parent: mail_manager

    greeting_card_manager:
        class:     %greeting_card_manager.class%
		parent: mail_manager</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;
&lt;parameters&gt;
    &lt;!-- ... --&gt;
    &lt;parameter key="newsletter_manager.class"&gt;Acme\HelloBundle\Mail\NewsletterManager&lt;/parameter&gt;
    &lt;parameter key="greeting_card_manager.class"&gt;Acme\HelloBundle\Mail\GreetingCardManager&lt;/parameter&gt;
    &lt;parameter key="mail_manager.class"&gt;Acme\HelloBundle\Mail\MailManager&lt;/parameter&gt;
&lt;/parameters&gt;

&lt;services&gt;
    &lt;service id="my_mailer" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="my_email_formatter" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="mail_manager" class="%mail_manager.class%" abstract="true"&gt;
        &lt;call method="setMailer"&gt;
             &lt;argument type="service" id="my_mailer" /&gt;
        &lt;/call&gt;
        &lt;call method="setEmailFormatter"&gt;
             &lt;argument type="service" id="my_email_formatter" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
    &lt;service id="newsletter_manager" class="%newsletter_manager.class%" parent="mail_manager"/&gt;
    &lt;service id="greeting_card_manager" class="%greeting_card_manager.class%" parent="mail_manager"/&gt;
		&lt;/services&gt;</pre>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\NewsletterManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'greeting_card_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\GreetingCardManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'mail_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\MailManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_email_formatter'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'mail_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%mail_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">SetAbstract</span><span class="p">(</span>
    <span class="k">true</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setMailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">)</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setEmailFormatter'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_email_formatter'</span><span class="p">)</span>
<span class="p">));</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">DefinitionDecorator</span><span class="p">(</span>
    <span class="s1">'mail_manager'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setClass</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span>
<span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'greeting_card_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">DefinitionDecorator</span><span class="p">(</span>
    <span class="s1">'mail_manager'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setClass</span><span class="p">(</span>
    <span class="s1">'%greeting_card_manager.class%'</span>
<span class="p">);</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>In this context, having a <tt class="docutils literal"><span class="pre">parent</span></tt> service implies that the arguments and
	method calls of the parent service should be used for the child services.
	Specifically, the setter methods defined for the parent service will be called
	when the child services are instantiated.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">If you remove the <tt class="docutils literal"><span class="pre">parent</span></tt> config key, the services will still be instantiated
	    and they will still of course extend the <tt class="docutils literal"><span class="pre">MailManager</span></tt> class. The difference
	    is that omitting the <tt class="docutils literal"><span class="pre">parent</span></tt> config key will mean that the <tt class="docutils literal"><span class="pre">calls</span></tt>
	    defined on the <tt class="docutils literal"><span class="pre">mail_manager</span></tt> service will not be executed when the
	    child services are instantiated.</p>
      </div></div>
      <p>The parent class is abstract as it should not be directly instantiated. Setting
	it to abstract in the config file as has been done above will mean that it
	can only be used as a parent service and cannot be used directly as a service
	to inject and will be removed at compile time. In other words, it exists merely
	as a "template" that other services can use.</p>
      <div class="section" id="overriding-parent-dependencies">
	<h2>Overriding Parent Dependencies<a class="headerlink" href="#overriding-parent-dependencies" title="Permalink to this headline">¶</a></h2>
	<p>There may be times where you want to override what class is passed in for
	  a dependency of one child service only. Fortunately, by adding the method
	  call config for the child service, the dependencies set by the parent class
	  will be overridden. So if you needed to pass a different dependency just
	  to the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt> class, the config would look like this:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 580px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Mail\NewsletterManager
    greeting_card_manager.class: Acme\HelloBundle\Mail\GreetingCardManager
    mail_manager.class: Acme\HelloBundle\Mail\MailManager
services:
    my_mailer:
        # ...
    my_alternative_mailer:
        # ...
    my_email_formatter:
        # ...
    mail_manager:
        class:     %mail_manager.class%
        abstract:  true
        calls:
            - [ setMailer, [ @my_mailer ] ]
            - [ setEmailFormatter, [ @my_email_formatter] ]

    newsletter_manager:
        class:     %newsletter_manager.class%
        parent: mail_manager
        calls:
            - [ setMailer, [ @my_alternative_mailer ] ]

    greeting_card_manager:
        class:     %greeting_card_manager.class%
		  parent: mail_manager</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;
&lt;parameters&gt;
    &lt;!-- ... --&gt;
    &lt;parameter key="newsletter_manager.class"&gt;Acme\HelloBundle\Mail\NewsletterManager&lt;/parameter&gt;
    &lt;parameter key="greeting_card_manager.class"&gt;Acme\HelloBundle\Mail\GreetingCardManager&lt;/parameter&gt;
    &lt;parameter key="mail_manager.class"&gt;Acme\HelloBundle\Mail\MailManager&lt;/parameter&gt;
&lt;/parameters&gt;

&lt;services&gt;
    &lt;service id="my_mailer" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="my_alternative_mailer" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="my_email_formatter" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="mail_manager" class="%mail_manager.class%" abstract="true"&gt;
        &lt;call method="setMailer"&gt;
             &lt;argument type="service" id="my_mailer" /&gt;
        &lt;/call&gt;
        &lt;call method="setEmailFormatter"&gt;
             &lt;argument type="service" id="my_email_formatter" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
    &lt;service id="newsletter_manager" class="%newsletter_manager.class%" parent="mail_manager"&gt;
         &lt;call method="setMailer"&gt;
             &lt;argument type="service" id="my_alternative_mailer" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
    &lt;service id="greeting_card_manager" class="%greeting_card_manager.class%" parent="mail_manager"/&gt;
		  &lt;/services&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\NewsletterManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'greeting_card_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\GreetingCardManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'mail_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\MailManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_alternative_mailer'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_email_formatter'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'mail_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%mail_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">SetAbstract</span><span class="p">(</span>
    <span class="k">true</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setMailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_mailer'</span><span class="p">)</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setEmailFormatter'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_email_formatter'</span><span class="p">)</span>
<span class="p">));</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">DefinitionDecorator</span><span class="p">(</span>
    <span class="s1">'mail_manager'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setClass</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setMailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_alternative_mailer'</span><span class="p">)</span>
<span class="p">));</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">DefinitionDecorator</span><span class="p">(</span>
    <span class="s1">'mail_manager'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setClass</span><span class="p">(</span>
    <span class="s1">'%greeting_card_manager.class%'</span>
<span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">GreetingCardManager</span></tt> will receive the same dependencies as before,
	  but the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt> will be passed the <tt class="docutils literal"><span class="pre">my_alternative_mailer</span></tt>
	  instead of the <tt class="docutils literal"><span class="pre">my_mailer</span></tt> service.</p>
      </div>
      <div class="section" id="collections-of-dependencies">
	<h2>Collections of Dependencies<a class="headerlink" href="#collections-of-dependencies" title="Permalink to this headline">¶</a></h2>
	<p>It should be noted that the overridden setter method in the previous example
	  is actually called twice - once per the parent definition and once per the
	  child definition. In the previous example, that was fine, since the second
	  <tt class="docutils literal"><span class="pre">setMailer</span></tt> call replaces mailer object set by the first call.</p>
	<p>In some cases, however, this can be a problem. For example, if the overridden
	  method call involves adding something to a collection, then two objects will
	  be added to that collection. The following shows such a case, if the parent
	  class looks like this:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Mail</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Acme\HelloBundle\Mailer</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\HelloBundle\EmailFormatter</span><span class="p">;</span>

<span class="k">abstract</span> <span class="k">class</span> <span class="nc">MailManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$filters</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setFilter</span><span class="p">(</span><span class="nv">$filter</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">filters</span><span class="p">[]</span> <span class="o">=</span> <span class="nv">$filter</span><span class="p">;</span>
    <span class="p">}</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>If you had the following config:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 436px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Mail\NewsletterManager
    mail_manager.class: Acme\HelloBundle\Mail\MailManager
services:
    my_filter:
        # ...
    another_filter:
        # ...
    mail_manager:
        class:     %mail_manager.class%
        abstract:  true
        calls:
            - [ setFilter, [ @my_filter ] ]

    newsletter_manager:
        class:     %newsletter_manager.class%
        parent: mail_manager
        calls:
		  - [ setFilter, [ @another_filter ] ]</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;
&lt;parameters&gt;
    &lt;!-- ... --&gt;
    &lt;parameter key="newsletter_manager.class"&gt;Acme\HelloBundle\Mail\NewsletterManager&lt;/parameter&gt;
    &lt;parameter key="mail_manager.class"&gt;Acme\HelloBundle\Mail\MailManager&lt;/parameter&gt;
&lt;/parameters&gt;

&lt;services&gt;
    &lt;service id="my_filter" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="another_filter" ... &gt;
      &lt;!-- ... --&gt;
    &lt;/service&gt;
    &lt;service id="mail_manager" class="%mail_manager.class%" abstract="true"&gt;
        &lt;call method="setFilter"&gt;
             &lt;argument type="service" id="my_filter" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
    &lt;service id="newsletter_manager" class="%newsletter_manager.class%" parent="mail_manager"&gt;
         &lt;call method="setFilter"&gt;
             &lt;argument type="service" id="another_filter" /&gt;
        &lt;/call&gt;
    &lt;/service&gt;
		  &lt;/services&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\NewsletterManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'mail_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Mail\MailManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'my_filter'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'another_filter'</span><span class="p">,</span> <span class="o">...</span> <span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'mail_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%mail_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">SetAbstract</span><span class="p">(</span>
    <span class="k">true</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setFilter'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'my_filter'</span><span class="p">)</span>
<span class="p">));</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">DefinitionDecorator</span><span class="p">(</span>
    <span class="s1">'mail_manager'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setClass</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">addMethodCall</span><span class="p">(</span><span class="s1">'setFilter'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'another_filter'</span><span class="p">)</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>In this example, the <tt class="docutils literal"><span class="pre">setFilter</span></tt> of the <tt class="docutils literal"><span class="pre">newsletter_manager</span></tt> service
	  will be called twice, resulting in the <tt class="docutils literal"><span class="pre">$filters</span></tt> array containing both
	  <tt class="docutils literal"><span class="pre">my_filter</span></tt> and <tt class="docutils literal"><span class="pre">another_filter</span></tt> objects. This is great if you just want
	  to add additional filters to the subclasses. If you want to replace the filters
	  passed to the subclass, removing the parent setting from the config will
	  prevent the base class from calling to <tt class="docutils literal"><span class="pre">setFilter</span></tt>.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to Use a Factory to Create Services" href="factories.html">
      «&nbsp;How to Use a Factory to Create Services
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use PdoSessionStorage to store Sessions in the Database" href="../configuration/pdo_session_storage.html">
      How to use PdoSessionStorage to store Sessions in the Database&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
