<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">MaxLength</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="maxlength">
      <h1>MaxLength<a class="headerlink" href="#maxlength" title="Permalink to this headline">¶</a></h1>
      <p>Validates that the string length of a value is not larger than the given limit.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="20%">
	  <col width="80%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Validates</td>
	    <td>a string</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">limit</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">message</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">charset</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Default Option</td>
	    <td><tt class="docutils literal"><span class="pre">limit</span></tt></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/Constraints/MaxLength.html" title="Symfony\Component\Validator\Constraints\MaxLength"><span class="pre">MaxLength</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">limit</span></tt> (<strong>default</strong>, required) [type: integer]</dt>
	      <dd><p class="first last">This is the maximum length of the string. If set to 10, the string must
		  be no more than 10 characters in length.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">message</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">This</span> <span class="pre">value</span> <span class="pre">is</span> <span class="pre">too</span> <span class="pre">long.</span> <span class="pre">It</span> <span class="pre">should</span> <span class="pre">have</span> <span class="pre">{{</span> <span class="pre">limit</span> <span class="pre">}}</span> <span class="pre">characters</span> <span class="pre">or</span> <span class="pre">less</span></tt>]</dt>
	      <dd><p class="first last">This is the validation error message when the validation fails.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
      <div class="section" id="basic-usage">
	<h2>Basic Usage<a class="headerlink" href="#basic-usage" title="Permalink to this headline">¶</a></h2>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\HelloBundle\Blog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">summary</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MaxLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">100</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\HelloBundle\Blog"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"summary"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MaxLength"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;value&gt;</span>100<span class="nt">&lt;/value&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Blog.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Blog</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\MaxLength(100)</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$summary</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Max" href="Max.html">
      «&nbsp;Max
    </a><span class="separator">|</span>
    <a accesskey="N" title="Min" href="Min.html">
      Min&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
