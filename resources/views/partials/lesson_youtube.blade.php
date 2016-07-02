<!-- LESSON -->
<div class="lesson youtube">

    <!-- WORD CANDIDATES -->
    <div class="supra-title">Learn the following words:</div>
    <div class="title">
        <div class="main-candidate"><?php echo array_shift($lesson['candidates']); ?></div>
        <div class="other-candidates"><?php echo implode(' ', $lesson['candidates']); ?></div>
    </div>

    <div class="body">

        <!-- THUMBNAIL -->
        <div class="thumbnail-container">
            <div class="thumbnail" style="background-image:url('http://img.youtube.com/vi/<?php echo $lesson['youtube']['youtube_id']; ?>/maxresdefault.jpg')"></div>
        </div>

        <!-- VIDEO TITLE -->
        <div class="infra-title">
            <?php echo $lesson['title']; ?>
        </div>
    </div>

</div>
