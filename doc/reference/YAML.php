<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">YAML</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="yaml">
      <span id="index-0"></span><h1>YAML<a class="headerlink" href="#yaml" title="Permalink to this headline">¶</a></h1>
      <p><a class="reference external" href="http://yaml.org/">YAML</a> website is "a human friendly data serialization standard for all
	programming languages". YAML is a simple language that describes data. As PHP,
	it has a syntax for simple types like strings, booleans, floats, or integers.
	But unlike PHP, it makes a difference between arrays (sequences) and hashes
	(mappings).</p>
      <p>The Symfony2 <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Yaml.html" title="Symfony\Component\Yaml"><span class="pre">Yaml</span></a></tt> Component knows how to
	parse YAML and dump a PHP array to YAML.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">Even if the YAML format can describe complex nested data structure, this
	    chapter only describes the minimum set of features needed to use YAML as a
	    configuration file format.</p>
      </div></div>
      <div class="section" id="reading-yaml-files">
	<h2>Reading YAML Files<a class="headerlink" href="#reading-yaml-files" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Yaml/Parser.html#parse()" title="Symfony\Component\Yaml\Parser::parse()"><span class="pre">parse()</span></a></tt> method parses a YAML
	  string and converts it to a PHP array:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Yaml\Parser</span><span class="p">;</span>

<span class="nv">$yaml</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Parser</span><span class="p">();</span>
<span class="nv">$value</span> <span class="o">=</span> <span class="nv">$yaml</span><span class="o">-&gt;</span><span class="na">parse</span><span class="p">(</span><span class="nb">file_get_contents</span><span class="p">(</span><span class="s1">'/path/to/file.yaml'</span><span class="p">));</span>
	  </pre></div>
	</div>
	<p>If an error occurs during parsing, the parser throws an exception indicating
	  the error type and the line in the original YAML string where the error
	  occurred:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">try</span> <span class="p">{</span>
    <span class="nv">$value</span> <span class="o">=</span> <span class="nv">$yaml</span><span class="o">-&gt;</span><span class="na">parse</span><span class="p">(</span><span class="nb">file_get_contents</span><span class="p">(</span><span class="s1">'/path/to/file.yaml'</span><span class="p">));</span>
<span class="p">}</span> <span class="k">catch</span> <span class="p">(</span><span class="nx">\InvalidArgumentException</span> <span class="nv">$e</span><span class="p">)</span> <span class="p">{</span>
    <span class="c1">// an error occurred during parsing</span>
    <span class="k">echo</span> <span class="s2">"Unable to parse the YAML string: "</span><span class="o">.</span><span class="nv">$e</span><span class="o">-&gt;</span><span class="na">getMessage</span><span class="p">();</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">As the parser is reentrant, you can use the same parser object to load
	      different YAML strings.</p>
	</div></div>
	<p>When loading a YAML file, it is sometimes better to use the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Yaml/Yaml.html#load()" title="Symfony\Component\Yaml\Yaml::load()"><span class="pre">load()</span></a></tt> wrapper method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Yaml\Yaml</span><span class="p">;</span>

<span class="nv">$loader</span> <span class="o">=</span> <span class="nx">Yaml</span><span class="o">::</span><span class="na">load</span><span class="p">(</span><span class="s1">'/path/to/file.yml'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">Yaml::load()</span></tt> static method takes a YAML string or a file containing
	  YAML. Internally, it calls the <tt class="docutils literal"><span class="pre">Parser::parse()</span></tt> method, but with some added
	  bonuses:</p>
	<ul class="simple">
	  <li>It executes the YAML file as if it was a PHP file, so that you can embed
	    PHP commands in YAML files;</li>
	  <li>When a file cannot be parsed, it automatically adds the file name to the
	    error message, simplifying debugging when your application is loading
	    several YAML files.</li>
	</ul>
      </div>
      <div class="section" id="writing-yaml-files">
	<h2>Writing YAML Files<a class="headerlink" href="#writing-yaml-files" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Yaml/Dumper.html#dump()" title="Symfony\Component\Yaml\Dumper::dump()"><span class="pre">dump()</span></a></tt> method dumps any PHP array
	  to its YAML representation:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Yaml\Dumper</span><span class="p">;</span>

<span class="nv">$array</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'bar'</span><span class="p">,</span> <span class="s1">'bar'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'bar'</span><span class="p">,</span> <span class="s1">'bar'</span> <span class="o">=&gt;</span> <span class="s1">'baz'</span><span class="p">));</span>

<span class="nv">$dumper</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Dumper</span><span class="p">();</span>
<span class="nv">$yaml</span> <span class="o">=</span> <span class="nv">$dumper</span><span class="o">-&gt;</span><span class="na">dump</span><span class="p">(</span><span class="nv">$array</span><span class="p">);</span>
<span class="nb">file_put_contents</span><span class="p">(</span><span class="s1">'/path/to/file.yaml'</span><span class="p">,</span> <span class="nv">$yaml</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">There are some limitations: the dumper is not able to dump resources and
	      dumping PHP objects is considered an alpha feature.</p>
	</div></div>
	<p>If you only need to dump one array, you can use the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Yaml/Yaml.html#dump()" title="Symfony\Component\Yaml\Yaml::dump()"><span class="pre">dump()</span></a></tt> static method shortcut:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$yaml</span> <span class="o">=</span> <span class="nx">Yaml</span><span class="o">::</span><span class="na">dump</span><span class="p">(</span><span class="nv">$array</span><span class="p">,</span> <span class="nv">$inline</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>The YAML format supports the two YAML array representations. By default, the
	  dumper uses the inline representation:</p>
	<div class="highlight-yaml"><div class="highlight"><pre><span class="p-Indicator">{</span> <span class="nv">foo</span><span class="p-Indicator">:</span> <span class="nv">bar</span><span class="p-Indicator">,</span> <span class="nv">bar</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">foo</span><span class="p-Indicator">:</span> <span class="nv">bar</span><span class="p-Indicator">,</span> <span class="nv">bar</span><span class="p-Indicator">:</span> <span class="nv">baz</span> <span class="p-Indicator">}</span> <span class="p-Indicator">}</span>
	  </pre></div>
	</div>
	<p>But the second argument of the <tt class="docutils literal"><span class="pre">dump()</span></tt> method customizes the level at which
	  the output switches from the expanded representation to the inline one:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">echo</span> <span class="nv">$dumper</span><span class="o">-&gt;</span><span class="na">dump</span><span class="p">(</span><span class="nv">$array</span><span class="p">,</span> <span class="mi">1</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">bar</span>
<span class="l-Scalar-Plain">bar</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">foo</span><span class="p-Indicator">:</span> <span class="nv">bar</span><span class="p-Indicator">,</span> <span class="nv">bar</span><span class="p-Indicator">:</span> <span class="nv">baz</span> <span class="p-Indicator">}</span>
	  </pre></div>
	</div>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">echo</span> <span class="nv">$dumper</span><span class="o">-&gt;</span><span class="na">dump</span><span class="p">(</span><span class="nv">$array</span><span class="p">,</span> <span class="mi">2</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">bar</span>
<span class="l-Scalar-Plain">bar</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">bar</span>
    <span class="l-Scalar-Plain">bar</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">baz</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="the-yaml-syntax">
	<h2>The YAML Syntax<a class="headerlink" href="#the-yaml-syntax" title="Permalink to this headline">¶</a></h2>
	<div class="section" id="strings">
	  <h3>Strings<a class="headerlink" href="#strings" title="Permalink to this headline">¶</a></h3>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">A string in YAML</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="s">'A</span><span class="nv"> </span><span class="s">singled-quoted</span><span class="nv"> </span><span class="s">string</span><span class="nv"> </span><span class="s">in</span><span class="nv"> </span><span class="s">YAML'</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>In a single quoted string, a single quote <tt class="docutils literal"><span class="pre">'</span></tt> must be doubled:</p>
	      <div class="last highlight-yaml"><div class="highlight"><pre><span class="s">'A</span><span class="nv"> </span><span class="s">single</span><span class="nv"> </span><span class="s">quote</span><span class="nv"> </span><span class="se">''</span><span class="nv"> </span><span class="s">in</span><span class="nv"> </span><span class="s">a</span><span class="nv"> </span><span class="s">single-quoted</span><span class="nv"> </span><span class="s">string'</span>
		</pre></div>
	      </div>
	  </div></div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="s">"A</span><span class="nv"> </span><span class="s">double-quoted</span><span class="nv"> </span><span class="s">string</span><span class="nv"> </span><span class="s">in</span><span class="nv"> </span><span class="s">YAML\n"</span>
	    </pre></div>
	  </div>
	  <p>Quoted styles are useful when a string starts or ends with one or more relevant
	    spaces.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The double-quoted style provides a way to express arbitrary strings, by
		using <tt class="docutils literal"><span class="pre">\</span></tt> escape sequences. It is very useful when you need to embed a
		<tt class="docutils literal"><span class="pre">\n</span></tt> or a unicode character in a string.</p>
	  </div></div>
	  <p>When a string contains line breaks, you can use the literal style, indicated
	    by the pipe (<tt class="docutils literal"><span class="pre">|</span></tt>), to indicate that the string will span several lines. In
	    literals, newlines are preserved:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="p-Indicator">|</span>
  <span class="no">\/ /| |\/| |</span>
  <span class="no">/ / | |  | |__</span>
	    </pre></div>
	  </div>
	  <p>Alternatively, strings can be written with the folded style, denoted by <tt class="docutils literal"><span class="pre">&gt;</span></tt>,
	    where each line break is replaced by a space:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="p-Indicator">&gt;</span>
  <span class="no">This is a very long sentence</span>
  <span class="no">that spans several lines in the YAML</span>
  <span class="no">but which will be rendered as a string</span>
  <span class="no">without carriage returns.</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Notice the two spaces before each line in the previous examples. They won't
		appear in the resulting PHP strings.</p>
	  </div></div>
	</div>
	<div class="section" id="numbers">
	  <h3>Numbers<a class="headerlink" href="#numbers" title="Permalink to this headline">¶</a></h3>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># an integer</span>
<span class="l-Scalar-Plain">12</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># an octal</span>
<span class="l-Scalar-Plain">014</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># an hexadecimal</span>
<span class="l-Scalar-Plain">0xC</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># a float</span>
<span class="l-Scalar-Plain">13.4</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># an exponential number</span>
<span class="l-Scalar-Plain">1.2e+34</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># infinity</span>
<span class="l-Scalar-Plain">.inf</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="nulls">
	  <h3>Nulls<a class="headerlink" href="#nulls" title="Permalink to this headline">¶</a></h3>
	  <p>Nulls in YAML can be expressed with <tt class="docutils literal"><span class="pre">null</span></tt> or <tt class="docutils literal"><span class="pre">~</span></tt>.</p>
	</div>
	<div class="section" id="booleans">
	  <h3>Booleans<a class="headerlink" href="#booleans" title="Permalink to this headline">¶</a></h3>
	  <p>Booleans in YAML are expressed with <tt class="docutils literal"><span class="pre">true</span></tt> and <tt class="docutils literal"><span class="pre">false</span></tt>.</p>
	</div>
	<div class="section" id="dates">
	  <h3>Dates<a class="headerlink" href="#dates" title="Permalink to this headline">¶</a></h3>
	  <p>YAML uses the ISO-8601 standard to express dates:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">2001-12-14t21:59:43.10-05:00</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># simple date</span>
<span class="l-Scalar-Plain">2002-12-14</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="collections">
	  <h3>Collections<a class="headerlink" href="#collections" title="Permalink to this headline">¶</a></h3>
	  <p>A YAML file is rarely used to describe a simple scalar. Most of the time, it
	    describes a collection. A collection can be a sequence or a mapping of
	    elements. Both sequences and mappings are converted to PHP arrays.</p>
	  <p>Sequences use a dash followed by a space (<tt class="docutils literal"><span class="pre">-</span></tt> ):</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="p-Indicator">-</span> <span class="l-Scalar-Plain">PHP</span>
<span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Perl</span>
<span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Python</span>
	    </pre></div>
	  </div>
	  <p>The previous YAML file is equivalent to the following PHP code:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span><span class="s1">'PHP'</span><span class="p">,</span> <span class="s1">'Perl'</span><span class="p">,</span> <span class="s1">'Python'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>Mappings use a colon followed by a space (<tt class="docutils literal"><span class="pre">:</span></tt> ) to mark each key/value pair:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">PHP</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">5.2</span>
<span class="l-Scalar-Plain">MySQL</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">5.1</span>
<span class="l-Scalar-Plain">Apache</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">2.2.20</span>
	    </pre></div>
	  </div>
	  <p>which is equivalent to this PHP code:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span><span class="s1">'PHP'</span> <span class="o">=&gt;</span> <span class="mf">5.2</span><span class="p">,</span> <span class="s1">'MySQL'</span> <span class="o">=&gt;</span> <span class="mf">5.1</span><span class="p">,</span> <span class="s1">'Apache'</span> <span class="o">=&gt;</span> <span class="s1">'2.2.20'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">In a mapping, a key can be any valid scalar.</p>
	  </div></div>
	  <p>The number of spaces between the colon and the value does not matter:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">PHP</span><span class="p-Indicator">:</span>    <span class="l-Scalar-Plain">5.2</span>
<span class="l-Scalar-Plain">MySQL</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">5.1</span>
<span class="l-Scalar-Plain">Apache</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">2.2.20</span>
	    </pre></div>
	  </div>
	  <p>YAML uses indentation with one or more spaces to describe nested collections:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="s">"symfony</span><span class="nv"> </span><span class="s">1.4"</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">PHP</span><span class="p-Indicator">:</span>      <span class="l-Scalar-Plain">5.2</span>
    <span class="l-Scalar-Plain">Doctrine</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">1.2</span>
<span class="s">"Symfony2"</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">PHP</span><span class="p-Indicator">:</span>      <span class="l-Scalar-Plain">5.3</span>
    <span class="l-Scalar-Plain">Doctrine</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">2.0</span>
	    </pre></div>
	  </div>
	  <p>The following YAML is equivalent to the following PHP code:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span>
    <span class="s1">'symfony 1.4'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'PHP'</span>      <span class="o">=&gt;</span> <span class="mf">5.2</span><span class="p">,</span>
        <span class="s1">'Doctrine'</span> <span class="o">=&gt;</span> <span class="mf">1.2</span><span class="p">,</span>
    <span class="p">),</span>
    <span class="s1">'Symfony2'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'PHP'</span>      <span class="o">=&gt;</span> <span class="mf">5.3</span><span class="p">,</span>
        <span class="s1">'Doctrine'</span> <span class="o">=&gt;</span> <span class="mf">2.0</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>There is one important thing you need to remember when using indentation in a
	    YAML file: <em>Indentation must be done with one or more spaces, but never with
	      tabulations</em>.</p>
	  <p>You can nest sequences and mappings as you like:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="s">'Chapter</span><span class="nv"> </span><span class="s">1'</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Introduction</span>
    <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Event Types</span>
<span class="s">'Chapter</span><span class="nv"> </span><span class="s">2'</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Introduction</span>
    <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Helpers</span>
	    </pre></div>
	  </div>
	  <p>YAML can also use flow styles for collections, using explicit indicators
	    rather than indentation to denote scope.</p>
	  <p>A sequence can be written as a comma separated list within square brackets
	    (<tt class="docutils literal"><span class="pre">[]</span></tt>):</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="p-Indicator">[</span><span class="nv">PHP</span><span class="p-Indicator">,</span> <span class="nv">Perl</span><span class="p-Indicator">,</span> <span class="nv">Python</span><span class="p-Indicator">]</span>
	    </pre></div>
	  </div>
	  <p>A mapping can be written as a comma separated list of key/values within curly
	    braces (<tt class="docutils literal"><span class="pre">{}</span></tt>):</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="p-Indicator">{</span> <span class="nv">PHP</span><span class="p-Indicator">:</span> <span class="nv">5.2</span><span class="p-Indicator">,</span> <span class="nv">MySQL</span><span class="p-Indicator">:</span> <span class="nv">5.1</span><span class="p-Indicator">,</span> <span class="nv">Apache</span><span class="p-Indicator">:</span> <span class="nv">2.2.20</span> <span class="p-Indicator">}</span>
	    </pre></div>
	  </div>
	  <p>You can mix and match styles to achieve a better readability:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="s">'Chapter</span><span class="nv"> </span><span class="s">1'</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">Introduction</span><span class="p-Indicator">,</span> <span class="nv">Event Types</span><span class="p-Indicator">]</span>
<span class="s">'Chapter</span><span class="nv"> </span><span class="s">2'</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">Introduction</span><span class="p-Indicator">,</span> <span class="nv">Helpers</span><span class="p-Indicator">]</span>
	    </pre></div>
	  </div>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="s">"symfony</span><span class="nv"> </span><span class="s">1.4"</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">PHP</span><span class="p-Indicator">:</span> <span class="nv">5.2</span><span class="p-Indicator">,</span> <span class="nv">Doctrine</span><span class="p-Indicator">:</span> <span class="nv">1.2</span> <span class="p-Indicator">}</span>
<span class="s">"Symfony2"</span><span class="p-Indicator">:</span>    <span class="p-Indicator">{</span> <span class="nv">PHP</span><span class="p-Indicator">:</span> <span class="nv">5.3</span><span class="p-Indicator">,</span> <span class="nv">Doctrine</span><span class="p-Indicator">:</span> <span class="nv">2.0</span> <span class="p-Indicator">}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="comments">
	  <h3>Comments<a class="headerlink" href="#comments" title="Permalink to this headline">¶</a></h3>
	  <p>Comments can be added in YAML by prefixing them with a hash mark (<tt class="docutils literal"><span class="pre">#</span></tt>):</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># Comment on a line</span>
<span class="s">"Symfony2"</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">PHP</span><span class="p-Indicator">:</span> <span class="nv">5.3</span><span class="p-Indicator">,</span> <span class="nv">Doctrine</span><span class="p-Indicator">:</span> <span class="nv">2.0</span> <span class="p-Indicator">}</span> <span class="c1"># Comment at the end of a line</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Comments are simply ignored by the YAML parser and do not need to be
		indented according to the current level of nesting in a collection.</p>
	  </div></div>
	</div>
	<div class="section" id="dynamic-yaml-files">
	  <h3>Dynamic YAML files<a class="headerlink" href="#dynamic-yaml-files" title="Permalink to this headline">¶</a></h3>
	  <p>In Symfony2, a YAML file can contain PHP code that is evaluated just before the
	    parsing occurs:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">1.0</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">version</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">&lt;?php echo file_get_contents('1.0/VERSION')."\n" ?&gt;</span>
<span class="l-Scalar-Plain">1.1</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">version</span><span class="p-Indicator">:</span> <span class="s">"&lt;?php</span><span class="nv"> </span><span class="s">echo</span><span class="nv"> </span><span class="s">file_get_contents('1.1/VERSION')</span><span class="nv"> </span><span class="s">?&gt;"</span>
	    </pre></div>
	  </div>
	  <p>Be careful to not mess up with the indentation. Keep in mind the following
	    simple tips when adding PHP code to a YAML file:</p>
	  <ul class="simple">
	    <li>The <tt class="docutils literal"><span class="pre">&lt;?php</span> <span class="pre">?&gt;</span></tt> statements must always start the line or be embedded in a
	      value.</li>
	    <li>If a <tt class="docutils literal"><span class="pre">&lt;?php</span> <span class="pre">?&gt;</span></tt> statement ends a line, you need to explicitly output a new
	      line ("n").</li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="The Dependency Injection Tags" href="dic_tags.html">
      «&nbsp;The Dependency Injection Tags
    </a><span class="separator">|</span>
    <a accesskey="N" title="Requirements for running Symfony2" href="requirements.html">
      Requirements for running Symfony2&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
