<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to secure any Service or Method in your Application</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-secure-any-service-or-method-in-your-application">
      <h1>How to secure any Service or Method in your Application<a class="headerlink" href="#how-to-secure-any-service-or-method-in-your-application" title="Permalink to this headline">¶</a></h1>
      <p>In the security chapter, you can see how to <a class="reference internal" href="../../book/security.html#book-security-securing-controller"><em>secure a controller</em></a>
	by requesting the <tt class="docutils literal"><span class="pre">security.context</span></tt> service from the Service Container
	and checking the current user's role:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\Exception\AccessDeniedException</span>
<span class="c1">// ...</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">if</span> <span class="p">(</span><span class="k">false</span> <span class="o">===</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">isGranted</span><span class="p">(</span><span class="s1">'ROLE_ADMIN'</span><span class="p">))</span> <span class="p">{</span>
        <span class="k">throw</span> <span class="k">new</span> <span class="nx">AccessDeniedException</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>You can also secure <em>any</em> service in a similar way by injecting the <tt class="docutils literal"><span class="pre">security.context</span></tt>
	service into it. For a general introduction to injecting dependencies into
	services see the <a class="reference internal" href="../../book/service_container.html"><em>Service Container</em></a> chapter of the book. For
	example, suppose you have a <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt> class that sends out emails
	and you want to restrict its use to only users who have some <tt class="docutils literal"><span class="pre">ROLE_NEWSLETTER_ADMIN</span></tt>
	role. Before you add security, the class looks something like this:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newsletter</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">sendNewsletter</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// where you actually do the work</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>Your goal is to check the user's role when the <tt class="docutils literal"><span class="pre">sendNewsletter()</span></tt> method is
	called. The first step towards this is to inject the <tt class="docutils literal"><span class="pre">security.context</span></tt>
	service into the object. Since it won't make sense <em>not</em> to perform the security
	check, this is an ideal candidate for constructor injection, which guarantees
	that the security context object will be available inside the <tt class="docutils literal"><span class="pre">NewsletterManager</span></tt>
	class:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newsletter</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\SecurityContextInterface</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$securityContext</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">SecurityContextInterface</span> <span class="nv">$securityContext</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">securityContext</span> <span class="o">=</span> <span class="nv">$securityContext</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>Then in your service configuration, you can inject the service:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 202px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># src/Acme/HelloBundle/Resources/config/services.yml
parameters:
    newsletter_manager.class: Acme\HelloBundle\Newsletter\NewsletterManager

services:
    newsletter_manager:
        class:     %newsletter_manager.class%
	arguments: [@security.context]</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;</span>
<span class="nt">&lt;parameters&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"newsletter_manager.class"</span><span class="nt">&gt;</span>Acme\HelloBundle\Newsletter\NewsletterManager<span class="nt">&lt;/parameter&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_manager"</span> <span class="na">class=</span><span class="s">"%newsletter_manager.class%"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"security.context"</span><span class="nt">/&gt;</span>
    <span class="nt">&lt;/service&gt;</span>
<span class="nt">&lt;/services&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'newsletter_manager.class'</span><span class="p">,</span> <span class="s1">'Acme\HelloBundle\Newsletter\NewsletterManager'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">))</span>
<span class="p">));</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>The injected service can then be used to perform the security check when the
	<tt class="docutils literal"><span class="pre">sendNewsletter()</span></tt> method is called:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newsletter</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\Exception\AccessDeniedException</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\SecurityContextInterface</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$securityContext</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">SecurityContextInterface</span> <span class="nv">$securityContext</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">securityContext</span> <span class="o">=</span> <span class="nv">$securityContext</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">sendNewsletter</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">if</span> <span class="p">(</span><span class="k">false</span> <span class="o">===</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">securityContext</span><span class="o">-&gt;</span><span class="na">isGranted</span><span class="p">(</span><span class="s1">'ROLE_NEWSLETTER_ADMIN'</span><span class="p">))</span> <span class="p">{</span>
            <span class="k">throw</span> <span class="k">new</span> <span class="nx">AccessDeniedException</span><span class="p">();</span>
        <span class="p">}</span>

        <span class="c1">//--</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>If the current user does not have the <tt class="docutils literal"><span class="pre">ROLE_NEWSLETTER_ADMIN</span></tt>, they will
	be prompted to log in.</p>
      <div class="section" id="securing-methods-using-annotations">
	<h2>Securing Methods Using Annotations<a class="headerlink" href="#securing-methods-using-annotations" title="Permalink to this headline">¶</a></h2>
	<p>You can also secure method calls in any service with annotations by using the
	  optional <a class="reference external" href="https://github.com/schmittjoh/SecurityExtraBundle">SecurityExtraBundle</a> bundle. This bundle is included in the Symfony2
	  Standard Distribution.</p>
	<p>To enable the annotations functionality, <a class="reference internal" href="../../book/service_container.html#book-service-container-tags"><em>tag</em></a>
	  the service you want to secure with the <tt class="docutils literal"><span class="pre">security.secure_service</span></tt> tag
	  (you can also automatically enable this functionality for all services, see
	  the <a class="reference internal" href="#securing-services-annotations-sidebar"><em>sidebar</em></a> below):</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 202px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/services.yml</span>
<span class="c1"># ...</span>

<span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">newsletter_manager</span><span class="p-Indicator">:</span>
        <span class="c1"># ...</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span>  <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">security.secure_service</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/services.xml --&gt;</span>
<span class="c">&lt;!-- ... --&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"newsletter_manager"</span> <span class="na">class=</span><span class="s">"%newsletter_manager.class%"</span><span class="nt">&gt;</span>
        <span class="c">&lt;!-- ... --&gt;</span>
        <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"security.secure_service"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/service&gt;</span>
<span class="nt">&lt;/services&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/services.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Definition</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\DependencyInjection\Reference</span><span class="p">;</span>

<span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span>
    <span class="s1">'%newsletter_manager.class%'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="k">new</span> <span class="nx">Reference</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">))</span>
<span class="p">));</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'security.secure_service'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'newsletter_manager'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>You can then achieve the same results as above using an annotation:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Newsletter</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">JMS\SecurityExtraBundle\Annotation\Secure</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="k">class</span> <span class="nc">NewsletterManager</span>
<span class="p">{</span>

    <span class="sd">/**</span>
<span class="sd">     * @Secure(roles="ROLE_NEWSLETTER_ADMIN")</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">sendNewsletter</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">//--</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The annotations work because a proxy class is created for your class
	      which performs the security checks. This means that, whilst you can use
	      annotations on public and protected methods, you cannot use them with
	      private methods or methods marked final.</p>
	</div></div>
	<p>The <tt class="docutils literal"><span class="pre">SecurityExtraBundle</span></tt> also allows you to secure the parameters and return
	  values of methods. For more information, see the <a class="reference external" href="https://github.com/schmittjoh/SecurityExtraBundle">SecurityExtraBundle</a>
	  documentation.</p>
	<div class="admonition-wrapper" id="securing-services-annotations-sidebar">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Activating the Annotations Functionality for all Services</p>
	    <p>When securing the method of a service (as shown above), you can either
	      tag each service individually, or activate the functionality for <em>all</em>
	      services at once. To do so, set the <tt class="docutils literal"><span class="pre">secure_all_services</span></tt> configuration
	      option to true:</p>
	    <div class="configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 130px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">jms_security_extra</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">secure_all_services</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;srv:container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/security"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:srv=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;jms_security_extra</span> <span class="na">secure_controllers=</span><span class="s">"true"</span> <span class="na">secure_all_services=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>

<span class="nt">&lt;/srv:container&gt;</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'jms_security_extra'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'secure_all_services'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	    <p class="last">The disadvantage of this method is that, if activated, the initial page
	      load may be very slow depending on how many services you have defined.</p>
	</div></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to customize your Form Login" href="form_login.html">
      «&nbsp;How to customize your Form Login
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to load Security Users from the Database (the entity Provider)" href="entity_provider.html">
      How to load Security Users from the Database (the entity Provider)&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
