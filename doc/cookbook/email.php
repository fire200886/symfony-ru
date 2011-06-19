<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to send an Email</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-send-an-email">
      <span id="index-0"></span><h1>How to send an Email<a class="headerlink" href="#how-to-send-an-email" title="Permalink to this headline">¶</a></h1>
      <p>Sending emails is a classic task for any web application and one that has
	special complications and potential pitfalls. Instead of recreating the wheel,
	one solution to send emails is to use the <tt class="docutils literal"><span class="pre">SwiftmailerBundle</span></tt>, which leverages
	the power of the <a class="reference external" href="http://www.swiftmailer.org/">Swiftmailer</a> library.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p>Don't forget to enable the bundle in your kernel before using it:</p>
	  <div class="last highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="c1">// ...</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle</span><span class="p">(),</span>
    <span class="p">);</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
      </div></div>
      <div class="section" id="configuration">
	<span id="swift-mailer-configuration"></span><h2>Configuration<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
	<p>Before using Swiftmailer, be sure to include its configuration. The only
	  mandatory configuration parameter is <tt class="docutils literal"><span class="pre">transport</span></tt>:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 202px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">swiftmailer</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">transport</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">smtp</span>
    <span class="l-Scalar-Plain">encryption</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">ssl</span>
    <span class="l-Scalar-Plain">auth_mode</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">login</span>
    <span class="l-Scalar-Plain">host</span><span class="p-Indicator">:</span>       <span class="l-Scalar-Plain">smtp.gmail.com</span>
    <span class="l-Scalar-Plain">username</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">your_username</span>
    <span class="l-Scalar-Plain">password</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">your_password</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>

<span class="c">&lt;!--</span>
<span class="c">xmlns:swiftmailer="http://symfony.com/schema/dic/swiftmailer"</span>
<span class="c">http://symfony.com/schema/dic/swiftmailer http://symfony.com/schema/dic/swiftmailer/swiftmailer-1.0.xsd</span>
<span class="c">--&gt;</span>

<span class="nt">&lt;swiftmailer:config</span>
    <span class="na">transport=</span><span class="s">"smtp"</span>
    <span class="na">encryption=</span><span class="s">"ssl"</span>
    <span class="na">auth-mode=</span><span class="s">"login"</span>
    <span class="na">host=</span><span class="s">"smtp.gmail.com"</span>
    <span class="na">username=</span><span class="s">"your_username"</span>
    <span class="na">password=</span><span class="s">"your_password"</span> <span class="nt">/&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'swiftmailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'transport'</span>  <span class="o">=&gt;</span> <span class="s2">"smtp"</span><span class="p">,</span>
    <span class="s1">'encryption'</span> <span class="o">=&gt;</span> <span class="s2">"ssl"</span><span class="p">,</span>
    <span class="s1">'auth_mode'</span>  <span class="o">=&gt;</span> <span class="s2">"login"</span><span class="p">,</span>
    <span class="s1">'host'</span>       <span class="o">=&gt;</span> <span class="s2">"smtp.gmail.com"</span><span class="p">,</span>
    <span class="s1">'username'</span>   <span class="o">=&gt;</span> <span class="s2">"your_username"</span><span class="p">,</span>
    <span class="s1">'password'</span>   <span class="o">=&gt;</span> <span class="s2">"your_password"</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The majority of the Swiftmailer configuration deals with how the messages
	  themselves should be delivered.</p>
	<p>The following configuration attributes are available:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">transport</span></tt>         (<tt class="docutils literal"><span class="pre">smtp</span></tt>, <tt class="docutils literal"><span class="pre">mail</span></tt>, <tt class="docutils literal"><span class="pre">sendmail</span></tt>, or <tt class="docutils literal"><span class="pre">gmail</span></tt>)</li>
	  <li><tt class="docutils literal"><span class="pre">username</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">password</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">host</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">port</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">encryption</span></tt>        (<tt class="docutils literal"><span class="pre">tls</span></tt>, or <tt class="docutils literal"><span class="pre">ssl</span></tt>)</li>
	  <li><tt class="docutils literal"><span class="pre">auth_mode</span></tt>         (<tt class="docutils literal"><span class="pre">plain</span></tt>, <tt class="docutils literal"><span class="pre">login</span></tt>, or <tt class="docutils literal"><span class="pre">cram-md5</span></tt>)</li>
	  <li><tt class="docutils literal"><span class="pre">spool</span></tt><ul>
	      <li><tt class="docutils literal"><span class="pre">type</span></tt> (how to queue the messages, only <tt class="docutils literal"><span class="pre">file</span></tt> is supported currently)</li>
	      <li><tt class="docutils literal"><span class="pre">path</span></tt> (where to store the messages)</li>
	    </ul>
	  </li>
	  <li><tt class="docutils literal"><span class="pre">delivery_address</span></tt>  (an email address where to send ALL emails)</li>
	  <li><tt class="docutils literal"><span class="pre">disable_delivery</span></tt>  (set to true to disable delivery completely)</li>
	</ul>
      </div>
      <div class="section" id="sending-emails">
	<h2>Sending Emails<a class="headerlink" href="#sending-emails" title="Permalink to this headline">¶</a></h2>
	<p>The Swiftmailer library works by creating, configuring and then sending
	  <tt class="docutils literal"><span class="pre">Swift_Message</span></tt> objects. The "mailer" is responsible for the actual delivery
	  of the message and is accessible via the <tt class="docutils literal"><span class="pre">mailer</span></tt> service. Overall, sending
	  an email is pretty straightforward:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$message</span> <span class="o">=</span> <span class="nx">\Swift_Message</span><span class="o">::</span><span class="na">newInstance</span><span class="p">()</span>
        <span class="o">-&gt;</span><span class="na">setSubject</span><span class="p">(</span><span class="s1">'Hello Email'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">setFrom</span><span class="p">(</span><span class="s1">'send@example.com'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">setTo</span><span class="p">(</span><span class="s1">'recipient@example.com'</span><span class="p">)</span>
        <span class="o">-&gt;</span><span class="na">setBody</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">renderView</span><span class="p">(</span><span class="s1">'HelloBundle:Hello:email.txt.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">)))</span>
    <span class="p">;</span>
    <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'mailer'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">(</span><span class="nv">$message</span><span class="p">);</span>

    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="o">...</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>To keep things decoupled, the email body has been stored in a template and
	  rendered with the <tt class="docutils literal"><span class="pre">renderView()</span></tt> method.</p>
	<p>The <tt class="docutils literal"><span class="pre">$message</span></tt> object supports many more options, such as including attachments,
	  adding HTML content, and much more. Fortunately, Swiftmailer covers the topic
	  of <a class="reference external" href="http://swiftmailer.org/docs/messages">Creating Messages</a> in great detail in its documentation.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Read the "<a class="reference internal" href="gmail.html"><em>How to use Gmail to send Emails</em></a>" recipe if you want to use Gmail as a transport in
	      the development environment.</p>
	</div></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to expose a Semantic Configuration for a Bundle" href="bundles/extension.html">
      «&nbsp;How to expose a Semantic Configuration for a Bundle
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use Gmail to send Emails" href="gmail.html">
      How to use Gmail to send Emails&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
