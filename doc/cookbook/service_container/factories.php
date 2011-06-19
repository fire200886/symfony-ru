<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to Use a Factory to Create Services</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-a-factory-to-create-services">
      <h1>How to Use a Factory to Create Services<a class="headerlink" href="#how-to-use-a-factory-to-create-services" title="Permalink to this headline">¶</a></h1>
      <p>Symfony2's Service Container provides a powerful way of controlling the
	creation of objects, allowing you to specify arguments passed to the constructor
	as well as calling methods and setting parameters. Sometimes, however, this
	will not provide you with everything you need to construct your objects.
	For this situation, you can use a factory to create the object and tell the
	service container to call a method on the factory rather than directly instantiating
	the object.</p>
      <p>Suppose you have a factory that configures and returns a new NewsletterManager
	object:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newletter</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterFactory</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">get</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$newsletterManager</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">NewsletterManager</span><span class="p">();</span>

        <span class="c1">// ...</span>

        <span class="k">return</span> <span class="nv">$newsletterManager</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>To make the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt> object available as a service, you can
	configure the service container to use the <tt class="docutils literal"><span class="pre">NewsletterFactory</span></tt> factory
	class:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 238px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Newsletter\NewsletterManager
    newsletter_factory.class: Acme\HelloBundle\Newsletter\NewsletterFactory
services:
    newsletter_manager:
        class:          %newsletter_manager.class%
        factory_class:  %newsletter_factory.class%
		factory_method: get</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;</span>
<span class="nt">&lt;parameters&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"newsletter_manager.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Newsletter\NewsletterManager<span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"newsletter_factory.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Newsletter\NewsletterFactory<span class="nt">&lt;/parameter&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_manager"</span>
             <span class="na">class=</span><span class="s">"%newsletter_manager.class%"</span>
             <span class="na">factory-class=</span><span class="s">"%newsletter_factory.class%"</span>
             <span class="na">factory-method=</span><span class="s">"get"</span>
    <span class="nt">/&gt;</span>
<span class="nt">&lt;/services&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_factory.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterFactory'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setFactoryClass</span><span class="p">(</span>
    <span class="s1">'%newsletter_factory.class%'</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">setFactoryMethod</span><span class="p">(</span>
    <span class="s1">'get'</span>
<span class="p">);</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>When you specify the class to use for the factory (via <tt class="docutils literal"><span class="pre">factory_class</span></tt>)
	the method will be called statically. If the factory itself should be instantiated
	and the resulting object's method called (as in this example), configure the
	factory itself as a service:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 274px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Newsletter\NewsletterManager
    newsletter_factory.class: Acme\HelloBundle\Newsletter\NewsletterFactory
services:
    newsletter_factory:
        class:            %newsletter_factory.class%
    newsletter_manager:
        class:            %newsletter_manager.class%
        factory_service:  newsletter_factory
		factory_method:   get</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;</span>
<span class="nt">&lt;parameters&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"newsletter_manager.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Newsletter\NewsletterManager<span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"newsletter_factory.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Newsletter\NewsletterFactory<span class="nt">&lt;/parameter&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_factory"</span> <span class="na">class=</span><span class="s">"%newsletter_factory.class%"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_manager"</span>
             <span class="na">class=</span><span class="s">"%newsletter_manager.class%"</span>
             <span class="na">factory-service=</span><span class="s">"newsletter_factory"</span>
             <span class="na">factory-method=</span><span class="s">"get"</span>
    <span class="nt">/&gt;</span>
<span class="nt">&lt;/services&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_factory.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterFactory'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_factory'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_factory.class%'</span>
<span class="p">))</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setFactoryService</span><span class="p">(</span>
    <span class="s1">'newsletter_factory'</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">setFactoryMethod</span><span class="p">(</span>
    <span class="s1">'get'</span>
<span class="p">);</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The factory service is specified by its id name and not a reference to
	    the service itself. So, you do not need to use the @ syntax.</p>
      </div></div>
      <div class="section" id="passing-arguments-to-the-factory-method">
	<h2>Passing Arguments to the Factory Method<a class="headerlink" href="#passing-arguments-to-the-factory-method" title="Permalink to this headline">¶</a></h2>
	<p>If you need to pass arguments to the factory method, you can use the <tt class="docutils literal"><span class="pre">arguments</span></tt>
	  options inside the service container. For example, suppose the <tt class="docutils literal"><span class="pre">get</span></tt> method
	  in the previous example takes the <tt class="docutils literal"><span class="pre">templating</span></tt> service as an argument:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 310px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    # ...
    newsletter_manager.class: Acme\HelloBundle\Newsletter\NewsletterManager
    newsletter_factory.class: Acme\HelloBundle\Newsletter\NewsletterFactory
services:
    newsletter_factory:
        class:            %newsletter_factory.class%
    newsletter_manager:
        class:            %newsletter_manager.class%
        factory_service:  newsletter_factory
        factory_method:   get
        arguments:
		  -             @templating</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;</span>
<span class="nt">&lt;parameters&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"newsletter_manager.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Newsletter\NewsletterManager<span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"newsletter_factory.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Newsletter\NewsletterFactory<span class="nt">&lt;/parameter&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_factory"</span> <span class="na">class=</span><span class="s">"%newsletter_factory.class%"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_manager"</span>
             <span class="na">class=</span><span class="s">"%newsletter_manager.class%"</span>
             <span class="na">factory-service=</span><span class="s">"newsletter_factory"</span>
             <span class="na">factory-method=</span><span class="s">"get"</span>
    <span class="nt">&gt;</span>
        <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"templating"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/service&gt;</span>
<span class="nt">&lt;/services&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>

<span class="c1">// ...</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterManager'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_factory.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterFactory'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_factory'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_factory.class%'</span>
<span class="p">))</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'templating'</span><span class="p">))</span>
<span class="p">))</span><span class="o">-&gt;</span><span class="na">setFactoryService</span><span class="p">(</span>
    <span class="s1">'newsletter_factory'</span>
<span class="p">)</span><span class="o">-&gt;</span><span class="na">setFactoryMethod</span><span class="p">(</span>
    <span class="s1">'get'</span>
<span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to Set External Parameters in the Service Container" href="../configuration/external_parameters.html">
      «&nbsp;How to Set External Parameters in the Service Container
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to Manage Common Dependencies with Parent Services" href="parentservices.html">
      How to Manage Common Dependencies with Parent Services&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
