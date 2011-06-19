<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to use Gmail to send Emails</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-gmail-to-send-emails">
      <span id="index-0"></span><h1>How to use Gmail to send Emails<a class="headerlink" href="#how-to-use-gmail-to-send-emails" title="Permalink to this headline">¶</a></h1>
      <p>During development, instead of using a regular SMTP server to send emails, you
	might find using Gmail easier and more practical. The Swiftmailer bundle makes
	it really easy.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">Instead of using your regular Gmail account, it's of course recommended
	    that you create a special account.</p>
      </div></div>
      <p>In the development configuration file, change the <tt class="docutils literal"><span class="pre">transport</span></tt> setting to
	<tt class="docutils literal"><span class="pre">gmail</span></tt> and set the <tt class="docutils literal"><span class="pre">username</span></tt> and <tt class="docutils literal"><span class="pre">password</span></tt> to the Google credentials:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 148px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config_dev.yml</span>
<span class="l-Scalar-Plain">swiftmailer</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">transport</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">gmail</span>
    <span class="l-Scalar-Plain">username</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">your_gmail_username</span>
    <span class="l-Scalar-Plain">password</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">your_gmail_password</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config_dev.xml --&gt;</span>

<span class="c">&lt;!--</span>
<span class="c">xmlns:swiftmailer="http://symfony.com/schema/dic/swiftmailer"</span>
<span class="c">http://symfony.com/schema/dic/swiftmailer http://symfony.com/schema/dic/swiftmailer/swiftmailer-1.0.xsd</span>
<span class="c">--&gt;</span>

<span class="nt">&lt;swiftmailer:config</span>
    <span class="na">transport=</span><span class="s">"gmail"</span>
    <span class="na">username=</span><span class="s">"your_gmail_username"</span>
    <span class="na">password=</span><span class="s">"your_gmail_password"</span> <span class="nt">/&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config_dev.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'swiftmailer'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'transport'</span> <span class="o">=&gt;</span> <span class="s2">"gmail"</span><span class="p">,</span>
    <span class="s1">'username'</span>  <span class="o">=&gt;</span> <span class="s2">"your_gmail_username"</span><span class="p">,</span>
    <span class="s1">'password'</span>  <span class="o">=&gt;</span> <span class="s2">"your_gmail_password"</span><span class="p">,</span>
<span class="p">));</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>You're done!</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The <tt class="docutils literal"><span class="pre">gmail</span></tt> transport is simply a shortcut that uses the <tt class="docutils literal"><span class="pre">smtp</span></tt> transport
	    and sets <tt class="docutils literal"><span class="pre">encryption</span></tt>, <tt class="docutils literal"><span class="pre">auth_mode</span></tt> and <tt class="docutils literal"><span class="pre">host</span></tt> to work with Gmail.</p>
      </div></div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to send an Email" href="email.html">
      «&nbsp;How to send an Email
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to simulate HTTP Authentication in a Functional Test" href="testing/http_authentication.html">
      How to simulate HTTP Authentication in a Functional Test&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
