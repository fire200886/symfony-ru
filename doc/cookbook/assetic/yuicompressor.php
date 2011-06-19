<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to Minify JavaScripts and Stylesheets with YUI Compressor</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-minify-javascripts-and-stylesheets-with-yui-compressor">
      <h1>How to Minify JavaScripts and Stylesheets with YUI Compressor<a class="headerlink" href="#how-to-minify-javascripts-and-stylesheets-with-yui-compressor" title="Permalink to this headline">¶</a></h1>
      <p>Yahoo! provides an excellent utility for minifying JavaScripts and stylesheets
	so they travel over the wire faster, the <a class="reference external" href="http://developer.yahoo.com/yui/compressor/">YUI Compressor</a>. Thanks to Assetic,
	you can take advantage of this tool very easily.</p>
      <div class="section" id="download-the-yui-compressor-jar">
	<h2>Download the YUI Compressor JAR<a class="headerlink" href="#download-the-yui-compressor-jar" title="Permalink to this headline">¶</a></h2>
	<p>The YUI Compressor is written in Java and distributed as a JAR. <a class="reference external" href="http://yuilibrary.com/downloads/#yuicompressor">Download the JAR</a>
	  from the Yahoo! site and save it to <tt class="docutils literal"><span class="pre">app/Resources/java/yuicompressor.jar</span></tt>.</p>
      </div>
      <div class="section" id="configure-the-yui-filters">
	<h2>Configure the YUI Filters<a class="headerlink" href="#configure-the-yui-filters" title="Permalink to this headline">¶</a></h2>
	<p>Now you need to configure two Assetic filters in your application, one for
	  minifying JavaScripts with the YUI Compressor and one for minifying
	  stylesheets:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 184px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">assetic</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">filters</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">yui_css</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">jar</span><span class="p-Indicator">:</span> <span class="s">"%kernel.root_dir%/Resources/java/yuicompressor.jar"</span>
        <span class="l-Scalar-Plain">yui_js</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">jar</span><span class="p-Indicator">:</span> <span class="s">"%kernel.root_dir%/Resources/java/yuicompressor.jar"</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;assetic:config&gt;</span>
    <span class="nt">&lt;assetic:filter</span>
        <span class="na">name=</span><span class="s">"yui_css"</span>
        <span class="na">jar=</span><span class="s">"%kernel.root_dir%/Resources/java/yuicompressor.jar"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;assetic:filter</span>
        <span class="na">name=</span><span class="s">"yui_js"</span>
        <span class="na">jar=</span><span class="s">"%kernel.root_dir%/Resources/java/yuicompressor.jar"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/assetic:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'assetic'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'filters'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'yui_css'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'jar'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.root_dir%/Resources/java/yuicompressor.jar'</span><span class="p">,</span>
        <span class="p">),</span>
        <span class="s1">'yui_js'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'jar'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.root_dir%/Resources/java/yuicompressor.jar'</span><span class="p">,</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>You now have access to two new Assetic filters in your application:
	  <tt class="docutils literal"><span class="pre">yui_css</span></tt> and <tt class="docutils literal"><span class="pre">yui_js</span></tt>. These will use the YUI Compressor to minify
	  stylesheets and JavaScripts, respectively.</p>
      </div>
      <div class="section" id="minify-your-assets">
	<h2>Minify your Assets<a class="headerlink" href="#minify-your-assets" title="Permalink to this headline">¶</a></h2>
	<p>You have YUI Compressor configured now, but nothing is going to happen until
	  you apply one of these filters to an asset. Since your assets are a part of
	  the view layer, this work is done in your templates:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{%</span> <span class="k">javascripts</span> <span class="s1">'js/src/*'</span> <span class="nv">filter</span><span class="o">=</span><span class="s1">'yui_js'</span> <span class="cp">%}</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">asset_url</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="cp">{%</span> <span class="k">endjavascripts</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$view</span><span class="p">[</span><span class="s1">'assetic'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">javascripts</span><span class="p">(</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'js/src/*'</span><span class="p">),</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'yui_js'</span><span class="p">))</span> <span class="k">as</span> <span class="nv">$url</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$url</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The above example assumes that your JavaScript files are in the <tt class="docutils literal"><span class="pre">js/src</span></tt>
	      directory. This isn't important however - you can include your Javascript
	      files no matter where they are.</p>
	</div></div>
	<p>With the addition of the <tt class="docutils literal"><span class="pre">yui_js</span></tt> filter to the asset tags above, you should
	  now see minified JavaScripts coming over the wire much faster. The same process
	  can be repeated to minify your stylesheets.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{%</span> <span class="k">stylesheets</span> <span class="s1">'css/src/*'</span> <span class="nv">filter</span><span class="o">=</span><span class="s1">'yui_css'</span> <span class="cp">%}</span>
<span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">type=</span><span class="s">"text/css"</span> <span class="na">media=</span><span class="s">"screen"</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">asset_url</span> <span class="cp">}}</span><span class="s">"</span> <span class="nt">/&gt;</span>
<span class="cp">{%</span> <span class="k">endstylesheets</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$view</span><span class="p">[</span><span class="s1">'assetic'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">stylesheets</span><span class="p">(</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'css/src/*'</span><span class="p">),</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'yui_css'</span><span class="p">))</span> <span class="k">as</span> <span class="nv">$url</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">type=</span><span class="s">"text/css"</span> <span class="na">media=</span><span class="s">"screen"</span> <span class="na">href=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$url</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="s">"</span> <span class="nt">/&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="disable-minification-in-debug-mode">
	<h2>Disable Minification in Debug Mode<a class="headerlink" href="#disable-minification-in-debug-mode" title="Permalink to this headline">¶</a></h2>
	<p>Minified JavaScripts and Stylesheets are very difficult to read, let alone
	  debug. Because of this, Assetic lets you disable a certain filter when your
	  application is in debug mode. You can do this be prefixing the filter name
	  in your template with a question mark: <tt class="docutils literal"><span class="pre">?</span></tt>. This tells Assetic to only
	  apply this filter when debug mode is off.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{%</span> <span class="k">javascripts</span> <span class="s1">'js/src/*'</span> <span class="nv">filter</span><span class="o">=</span><span class="s1">'?yui_js'</span> <span class="cp">%}</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">asset_url</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="cp">{%</span> <span class="k">endjavascripts</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$view</span><span class="p">[</span><span class="s1">'assetic'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">javascripts</span><span class="p">(</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'js/src/*'</span><span class="p">),</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'?yui_js'</span><span class="p">))</span> <span class="k">as</span> <span class="nv">$url</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$url</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="s">"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to force routes to always use HTTPS" href="../routing/scheme.html">
      «&nbsp;How to force routes to always use HTTPS
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to use PHP instead of Twig for Templates" href="../templating/PHP.html">
      How to use PHP instead of Twig for Templates&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
