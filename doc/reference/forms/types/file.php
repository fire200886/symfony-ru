<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">file Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="file-field-type">
      <span id="index-0"></span><h1>file Field Type<a class="headerlink" href="#file-field-type" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">file</span></tt> type represents a file input in your form.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="16%">
	  <col width="84%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td><tt class="docutils literal"><span class="pre">input</span></tt> <tt class="docutils literal"><span class="pre">file</span></tt> field</td>
	  </tr>
	  <tr><td>Options</td>
	    <td>none</td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="field.html"><em>form</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/FileType.html" title="Symfony\Component\Form\Extension\Core\Type\FileType"><span class="pre">FileType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="basic-usage">
	<h2>Basic Usage<a class="headerlink" href="#basic-usage" title="Permalink to this headline">¶</a></h2>
	<p>Let's say you have this form definition:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'attachment'</span><span class="p">,</span> <span class="s1">'file'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
	    <p class="last">Don't forget to add the <tt class="docutils literal"><span class="pre">enctype</span></tt> attribute in the form tag: <tt class="docutils literal"><span class="pre">&lt;form</span>
		<span class="pre">action="#"</span> <span class="pre">method="post"</span> <span class="pre">{{</span> <span class="pre">form_enctype(form)</span> <span class="pre">}}&gt;</span></tt>.</p>
	</div></div>
	<p>When the form is submitted, the <tt class="docutils literal"><span class="pre">attachment</span></tt> field will be an instance of
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/File/UploadedFile.html" title="Symfony\Component\HttpFoundation\File\UploadedFile"><span class="pre">UploadedFile</span></a></tt>. It can be
	  used to move the <tt class="docutils literal"><span class="pre">attachment</span></tt> file to a permanent location:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\File\UploadedFile</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">uploadAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="k">if</span> <span class="p">(</span><span class="nv">$form</span><span class="o">-&gt;</span><span class="na">isValid</span><span class="p">())</span> <span class="p">{</span>
        <span class="nv">$form</span><span class="p">[</span><span class="s1">'attachment'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">move</span><span class="p">(</span><span class="nv">$dir</span><span class="p">,</span> <span class="nv">$file</span><span class="p">);</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">move()</span></tt> method takes a directory and a file name as its arguments:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// use the original file name</span>
<span class="nv">$file</span><span class="o">-&gt;</span><span class="na">move</span><span class="p">(</span><span class="nv">$dir</span><span class="p">,</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getClientOriginalName</span><span class="p">());</span>

<span class="c1">// compute a random name and try to guess the extension (more secure)</span>
<span class="nv">$extension</span> <span class="o">=</span> <span class="nv">$file</span><span class="o">-&gt;</span><span class="na">guessExtension</span><span class="p">();</span>
<span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nv">$extension</span><span class="p">)</span> <span class="p">{</span>
    <span class="c1">// extension cannot be guessed</span>
    <span class="nv">$extension</span> <span class="o">=</span> <span class="s1">'bin'</span><span class="p">;</span>
<span class="p">}</span>
<span class="nv">$file</span><span class="o">-&gt;</span><span class="na">move</span><span class="p">(</span><span class="nv">$dir</span><span class="p">,</span> <span class="nb">rand</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span> <span class="mi">99999</span><span class="p">)</span><span class="o">.</span><span class="s1">'.'</span><span class="o">.</span><span class="nv">$extension</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Using the original name via <tt class="docutils literal"><span class="pre">getClientOriginalName()</span></tt> is not safe as it
	  could have been manipulated by the end-user. Moreover, it can contain
	  characters that are not allowed in file names. You should sanitize the name
	  before using it directly.</p>
	<p>Read the <a class="reference internal" href="../../../cookbook/doctrine/file_uploads.html"><em>cookbook</em></a> for an example of
	  how to manage a file upload associated with a Doctrine entity.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="entity Field Type" href="entity.html">
      «&nbsp;entity Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Abstract &quot;field&quot; Type" href="field.html">
      The Abstract "field" Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
