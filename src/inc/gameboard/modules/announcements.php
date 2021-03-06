<?hh // strict

require_once ($_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php');

/* HH_IGNORE_ERROR[1002] */
SessionUtils::sessionStart();
SessionUtils::enforceLogin();

class AnnouncementsModuleController {
  public async function genRender(): Awaitable<:xhp> {
    await tr_start();
    $announcements = await Announcement::genAllAnnouncements();
    $announcements_ul = <ul class="activity-stream announcements-list"></ul>;
    if ($announcements) {
      foreach ($announcements as $announcement) {
        $announcements_ul->appendChild(
          <li>
            <span class="announcement-highlight">
              {$announcement->getAnnouncement()}
            </span>
          </li>
        );
      }
    }

    return
      <div>
        <header class="module-header">
          <h6>{tr('Announcements')}</h6>
        </header>
        <div class="module-content">
          <div class="fb-section-border">
            <div class="module-top"></div>
            <div class="module-scrollable">
              {$announcements_ul}
            </div>
          </div>
        </div>
      </div>;
  }
}

$announcements_generated = new AnnouncementsModuleController();
echo \HH\Asio\join($announcements_generated->genRender());
