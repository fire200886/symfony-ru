<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to customize your Form Login</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-customize-your-form-login">
      <h1>How to customize your Form Login<a class="headerlink" href="#how-to-customize-your-form-login" title="Permalink to this headline">¶</a></h1>
      <p>This article has not been fully written yet, but will soon. If you're interested
	in writing this entry, see <a class="reference internal" href="../../contributing/documentation/overview.html"><em>Contributing to the Documentation</em></a>.</p>
      <div class="section" id="form-login-configuration-reference">
	<h2>Form Login Configuration Reference<a class="headerlink" href="#form-login-configuration-reference" title="Permalink to this headline">¶</a></h2>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 274px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">main</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">form_login</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">check_path</span><span class="p-Indicator">:</span>                     <span class="l-Scalar-Plain">/login_check</span>
                <span class="l-Scalar-Plain">login_path</span><span class="p-Indicator">:</span>                     <span class="l-Scalar-Plain">/login</span>
                <span class="l-Scalar-Plain">failure_path</span><span class="p-Indicator">:</span>                   <span class="l-Scalar-Plain">null</span>
                <span class="l-Scalar-Plain">always_use_default_target_path</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">false</span>
                <span class="l-Scalar-Plain">default_target_path</span><span class="p-Indicator">:</span>            <span class="l-Scalar-Plain">/</span>
                <span class="l-Scalar-Plain">target_path_parameter</span><span class="p-Indicator">:</span>          <span class="l-Scalar-Plain">_target_path</span>
                <span class="l-Scalar-Plain">use_referer</span><span class="p-Indicator">:</span>                    <span class="l-Scalar-Plain">false</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/security.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;firewall&gt;</span>
        <span class="nt">&lt;form-login</span>
            <span class="na">check_path=</span><span class="s">"/login_check"</span>
            <span class="na">login_path=</span><span class="s">"/login"</span>
            <span class="na">failure_path=</span><span class="s">"null"</span>
            <span class="na">always_use_default_target_path=</span><span class="s">"false"</span>
            <span class="na">default_target_path=</span><span class="s">"/"</span>
            <span class="na">target_path_parameter=</span><span class="s">"_target_path"</span>
            <span class="na">use_referer=</span><span class="s">"false"</span>
        <span class="nt">/&gt;</span>
    <span class="nt">&lt;/firewall&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/security.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'main'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'form_login'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'check_path'</span>                     <span class="o">=&gt;</span> <span class="s1">'/login_check'</span><span class="p">,</span>
            <span class="s1">'login_path'</span>                     <span class="o">=&gt;</span> <span class="s1">'/login'</span><span class="p">,</span>
            <span class="s1">'failure_path'</span>                   <span class="o">=&gt;</span> <span class="k">null</span><span class="p">,</span>
            <span class="s1">'always_use_default_target_path'</span> <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
            <span class="s1">'default_target_path'</span>            <span class="o">=&gt;</span> <span class="s1">'/'</span><span class="p">,</span>
            <span class="s1">'target_path_parameter'</span>          <span class="o">=&gt;</span> <span class="nx">_target_path</span><span class="p">,</span>
            <span class="s1">'use_referer'</span>                    <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
        <span class="p">)),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<ul class="simple">
	  <li>if <tt class="docutils literal"><span class="pre">always_use_default_target_path</span></tt> is <tt class="docutils literal"><span class="pre">true</span></tt> (<tt class="docutils literal"><span class="pre">false</span></tt> by default),
	    redirect the user to the <tt class="docutils literal"><span class="pre">default_target_path</span></tt> (<tt class="docutils literal"><span class="pre">/</span></tt> by default);</li>
	  <li>if the request contains a parameter named <tt class="docutils literal"><span class="pre">_target_path</span></tt> (configurable via
	    <tt class="docutils literal"><span class="pre">target_path_parameter</span></tt>), redirect the user to this parameter value;</li>
	  <li>if there is a target URL stored in the session (which is done automatically
	    when a user is redirected to the login page), redirect the user to that URL;</li>
	  <li>if <tt class="docutils literal"><span class="pre">use_referer</span></tt> is set to <tt class="docutils literal"><span class="pre">true</span></tt> (<tt class="docutils literal"><span class="pre">false</span></tt> is the default), redirect
	    the user to the Referrer URL;</li>
	  <li>Redirect the user to the <tt class="docutils literal"><span class="pre">default_target_path</span></tt> URL (<tt class="docutils literal"><span class="pre">/</span></tt> by default).</li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to force HTTPS or HTTP for Different URLs" href="force_https.html">
      «&nbsp;How to force HTTPS or HTTP for Different URLs
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to secure any Service or Method in your Application" href="securing_services.html">
      How to secure any Service or Method in your Application&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
