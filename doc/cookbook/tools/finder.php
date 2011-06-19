<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to locate Files</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-locate-files">
      <span id="index-0"></span><h1>How to locate Files<a class="headerlink" href="#how-to-locate-files" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder.html" title="Symfony\Component\Finder"><span class="pre">Finder</span></a></tt> component helps you to find files
	and directories quickly and easily.</p>
      <div class="section" id="usage">
	<h2>Usage<a class="headerlink" href="#usage" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html" title="Symfony\Component\Finder\Finder"><span class="pre">Finder</span></a></tt> class finds files and/or
	  directories:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Finder\Finder</span><span class="p">;</span>

<span class="nv">$finder</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Finder</span><span class="p">();</span>
<span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">in</span><span class="p">(</span><span class="nx">__DIR__</span><span class="p">);</span>

<span class="k">foreach</span> <span class="p">(</span><span class="nv">$finder</span> <span class="k">as</span> <span class="nv">$file</span><span class="p">)</span> <span class="p">{</span>
    <span class="k">print</span> <span class="nv">$file</span><span class="o">-&gt;</span><span class="na">getRealpath</span><span class="p">()</span><span class="o">.</span><span class="s2">"</span><span class="se">\n</span><span class="s2">"</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">$file</span></tt> is an instance of <tt class="docutils literal"><a class="reference external" href="http://php.net/manual/en/class.splfileinfo.php" title="SplFileInfo"><span class="pre">SplFileInfo</span></a></tt>.</p>
	<p>The above code prints the names of all the files in the current directory
	  recursively. The Finder class uses a fluent interface, so all methods return
	  the Finder instance.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">A Finder instance is a PHP <a class="reference external" href="http://www.php.net/manual/en/spl.iterators.php">Iterator</a>. So, instead of iterating over the
	      Finder with <tt class="docutils literal"><span class="pre">foreach</span></tt>, you can also convert it to an array with the
	      <tt class="docutils literal"><a class="reference external" href="http://php.net/manual/en/function.iterator-to-array.php" title="iterator_to_array"><span class="pre">iterator_to_array</span></a></tt> method, or get the number of items with
	      <tt class="docutils literal"><a class="reference external" href="http://php.net/manual/en/function.iterator-count.php" title="iterator_count"><span class="pre">iterator_count</span></a></tt>.</p>
	</div></div>
      </div>
      <div class="section" id="criteria">
	<h2>Criteria<a class="headerlink" href="#criteria" title="Permalink to this headline">¶</a></h2>
	<div class="section" id="location">
	  <h3>Location<a class="headerlink" href="#location" title="Permalink to this headline">¶</a></h3>
	  <p>The location is the only mandatory criteria. It tells the finder which
	    directory to use for the search:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">in</span><span class="p">(</span><span class="nx">__DIR__</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>Search in several locations by chaining calls to
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#in()" title="Symfony\Component\Finder\Finder::in()"><span class="pre">in()</span></a></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">in</span><span class="p">(</span><span class="nx">__DIR__</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">in</span><span class="p">(</span><span class="s1">'/elsewhere'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>Exclude directories from matching with the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#exclude()" title="Symfony\Component\Finder\Finder::exclude()"><span class="pre">exclude()</span></a></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">in</span><span class="p">(</span><span class="nx">__DIR__</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">exclude</span><span class="p">(</span><span class="s1">'ruby'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>As the Finder uses PHP iterators, you can pass any URL with a supported
	    <a class="reference external" href="http://www.php.net/manual/en/wrappers.php">protocol</a>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">in</span><span class="p">(</span><span class="s1">'ftp://example.com/pub/'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>And it also works with user-defined streams:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Finder\Finder</span><span class="p">;</span>

<span class="nv">$s3</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">\Zend_Service_Amazon_S3</span><span class="p">(</span><span class="nv">$key</span><span class="p">,</span> <span class="nv">$secret</span><span class="p">);</span>
<span class="nv">$s3</span><span class="o">-&gt;</span><span class="na">registerStreamWrapper</span><span class="p">(</span><span class="s2">"s3"</span><span class="p">);</span>

<span class="nv">$finder</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Finder</span><span class="p">();</span>
<span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">name</span><span class="p">(</span><span class="s1">'photos*'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">size</span><span class="p">(</span><span class="s1">'&lt; 100K'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">date</span><span class="p">(</span><span class="s1">'since 1 hour ago'</span><span class="p">);</span>
<span class="k">foreach</span> <span class="p">(</span><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">in</span><span class="p">(</span><span class="s1">'s3://bucket-name'</span><span class="p">)</span> <span class="k">as</span> <span class="nv">$file</span><span class="p">)</span> <span class="p">{</span>
    <span class="c1">// do something</span>

    <span class="k">print</span> <span class="nv">$file</span><span class="o">-&gt;</span><span class="na">getFilename</span><span class="p">()</span><span class="o">.</span><span class="s2">"</span><span class="se">\n</span><span class="s2">"</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Read the <a class="reference external" href="http://www.php.net/streams">Streams</a> documentation to learn how to create your own streams.</p>
	  </div></div>
	</div>
	<div class="section" id="files-or-directories">
	  <h3>Files or Directories<a class="headerlink" href="#files-or-directories" title="Permalink to this headline">¶</a></h3>
	  <p>By default, the Finder returns files and directories; but the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#files()" title="Symfony\Component\Finder\Finder::files()"><span class="pre">files()</span></a></tt> and
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#directories()" title="Symfony\Component\Finder\Finder::directories()"><span class="pre">directories()</span></a></tt> methods control that:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">();</span>

<span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">directories</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>If you want to follow links, use the <tt class="docutils literal"><span class="pre">followLinks()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">followLinks</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>By default, the iterator ignores popular VCS files. This can be changed with
	    the <tt class="docutils literal"><span class="pre">ignoreVCS()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">ignoreVCS</span><span class="p">(</span><span class="k">false</span><span class="p">);</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="sorting">
	  <h3>Sorting<a class="headerlink" href="#sorting" title="Permalink to this headline">¶</a></h3>
	  <p>Sort the result by name or by type (directories first, then files):</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">sortByName</span><span class="p">();</span>

<span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">sortByType</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Notice that the <tt class="docutils literal"><span class="pre">sort*</span></tt> methods need to get all matching elements to do
		their jobs. For large iterators, it is slow.</p>
	  </div></div>
	  <p>You can also define your own sorting algorithm with <tt class="docutils literal"><span class="pre">sort()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$sort</span> <span class="o">=</span> <span class="k">function</span> <span class="p">(</span><span class="nx">\SplFileInfo</span> <span class="nv">$a</span><span class="p">,</span> <span class="nx">\SplFileInfo</span> <span class="nv">$b</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="nb">strcmp</span><span class="p">(</span><span class="nv">$a</span><span class="o">-&gt;</span><span class="na">getRealpath</span><span class="p">(),</span> <span class="nv">$b</span><span class="o">-&gt;</span><span class="na">getRealpath</span><span class="p">());</span>
<span class="p">};</span>

<span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">sort</span><span class="p">(</span><span class="nv">$sort</span><span class="p">);</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="file-name">
	  <h3>File Name<a class="headerlink" href="#file-name" title="Permalink to this headline">¶</a></h3>
	  <p>Restrict files by name with the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#name()" title="Symfony\Component\Finder\Finder::name()"><span class="pre">name()</span></a></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">name</span><span class="p">(</span><span class="s1">'*.php'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">name()</span></tt> method accepts globs, strings, or regexes:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">name</span><span class="p">(</span><span class="s1">'/\.php$/'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">notNames()</span></tt> method excludes files matching a pattern:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">notName</span><span class="p">(</span><span class="s1">'*.rb'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="file-size">
	  <h3>File Size<a class="headerlink" href="#file-size" title="Permalink to this headline">¶</a></h3>
	  <p>Restrict files by size with the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#size()" title="Symfony\Component\Finder\Finder::size()"><span class="pre">size()</span></a></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">size</span><span class="p">(</span><span class="s1">'&lt; 1.5K'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>Restrict by a size range by chaining calls:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">size</span><span class="p">(</span><span class="s1">'&gt;= 1K'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">size</span><span class="p">(</span><span class="s1">'&lt;= 2K'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The comparison operator can be any of the following: <tt class="docutils literal"><span class="pre">&gt;</span></tt>, <tt class="docutils literal"><span class="pre">&gt;=</span></tt>, <tt class="docutils literal"><span class="pre">&lt;</span></tt>, '&lt;=',
	    '=='.</p>
	  <p>The target value may use magnitudes of kilobytes (<tt class="docutils literal"><span class="pre">k</span></tt>, <tt class="docutils literal"><span class="pre">ki</span></tt>), megabytes
	    (<tt class="docutils literal"><span class="pre">m</span></tt>, <tt class="docutils literal"><span class="pre">mi</span></tt>), or gigabytes (<tt class="docutils literal"><span class="pre">g</span></tt>, <tt class="docutils literal"><span class="pre">gi</span></tt>). Those suffixed with an <tt class="docutils literal"><span class="pre">i</span></tt> use
	    the appropriate <tt class="docutils literal"><span class="pre">2**n</span></tt> version in accordance with the <a class="reference external" href="http://physics.nist.gov/cuu/Units/binary.html">IEC standard</a>.</p>
	</div>
	<div class="section" id="file-date">
	  <h3>File Date<a class="headerlink" href="#file-date" title="Permalink to this headline">¶</a></h3>
	  <p>Restrict files by last modified dates with the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#date()" title="Symfony\Component\Finder\Finder::date()"><span class="pre">date()</span></a></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">date</span><span class="p">(</span><span class="s1">'since yesterday'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The comparison operator can be any of the following: <tt class="docutils literal"><span class="pre">&gt;</span></tt>, <tt class="docutils literal"><span class="pre">&gt;=</span></tt>, <tt class="docutils literal"><span class="pre">&lt;</span></tt>, '&lt;=',
	    '=='. You can also use <tt class="docutils literal"><span class="pre">since</span></tt> or <tt class="docutils literal"><span class="pre">after</span></tt> as an alias for <tt class="docutils literal"><span class="pre">&gt;</span></tt>, and
	    <tt class="docutils literal"><span class="pre">until</span></tt> or <tt class="docutils literal"><span class="pre">before</span></tt> as an alias for <tt class="docutils literal"><span class="pre">&lt;</span></tt>.</p>
	  <p>The target value can be any date supported by the <a class="reference external" href="http://www.php.net/manual/en/datetime.formats.php">strtotime</a> function.</p>
	</div>
	<div class="section" id="directory-depth">
	  <h3>Directory Depth<a class="headerlink" href="#directory-depth" title="Permalink to this headline">¶</a></h3>
	  <p>By default, the Finder recursively traverse directories. Restrict the depth of
	    traversing with <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#depth()" title="Symfony\Component\Finder\Finder::depth()"><span class="pre">depth()</span></a></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">depth</span><span class="p">(</span><span class="s1">'== 0'</span><span class="p">);</span>
<span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">depth</span><span class="p">(</span><span class="s1">'&lt; 3'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="custom-filtering">
	  <h3>Custom Filtering<a class="headerlink" href="#custom-filtering" title="Permalink to this headline">¶</a></h3>
	  <p>To restrict the matching file with your own strategy, use
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Finder/Finder.html#filter()" title="Symfony\Component\Finder\Finder::filter()"><span class="pre">filter()</span></a></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$filter</span> <span class="o">=</span> <span class="k">function</span> <span class="p">(</span><span class="nx">\SplFileInfo</span> <span class="nv">$file</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">if</span> <span class="p">(</span><span class="nb">strlen</span><span class="p">(</span><span class="nv">$file</span><span class="p">)</span> <span class="o">&gt;</span> <span class="mi">10</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">return</span> <span class="k">false</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">};</span>

<span class="nv">$finder</span><span class="o">-&gt;</span><span class="na">files</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">filter</span><span class="p">(</span><span class="nv">$filter</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">filter()</span></tt> method takes a Closure as an argument. For each matching file,
	    it is called with the file as a <tt class="docutils literal"><a class="reference external" href="http://php.net/manual/en/class.splfileinfo.php" title="SplFileInfo"><span class="pre">SplFileInfo</span></a></tt> instance. The file is
	    excluded from the result set if the Closure returns <tt class="docutils literal"><span class="pre">false</span></tt>.</p>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to autoload Classes" href="autoloader.html">
      «&nbsp;How to autoload Classes
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to create Console/Command-Line Commands" href="../console.html">
      How to create Console/Command-Line Commands&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
