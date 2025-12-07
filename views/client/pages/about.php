<?php
$title1 = $aboutData['title1'] ?? 'Nhóm phát triển BK Figure Lab - NODATA';
$subtitle1 = $aboutData['subtitle1'] ?? 'Chúng tôi là những sinh viên đam mê công nghệ và yêu thích thế giới mô hình.';
$subtitle2 = $aboutData['subtitle2'] ?? 'BK Figure Lab - Nơi hội tụ đam mê';
$aboutContent = $aboutData['about'] ?? '';
?>

<section class="team-section py-5 bg-white">
  <div class="container text-center">
    <h2 class="fw-bold text-primary mb-4">
      <i class="bi bi-person-hearts me-2"></i><?= htmlspecialchars($title1) ?>
    </h2>
    <p class="text-muted mb-5"><?= htmlspecialchars($subtitle1) ?></p>

    <div class="row justify-content-center g-4">
      <?php for ($i = 1; $i <= 3; $i++): ?>
        <?php
        $name = $aboutData["name$i"] ?? "Thành viên $i";
        $mssv = $aboutData["mssv$i"] ?? "MSSV";
        $mission = $aboutData["mission$i"] ?? "Nhiệm vụ nhóm $i";
        $avatar = $aboutData["avatar$i"] ?? "https://picsum.photos/300/300?random=" . (10 + $i);
        ?>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm team-card p-3 h-100">
            <img src="<?= htmlspecialchars($avatar) ?>" alt="<?= htmlspecialchars($name) ?>"
              class="rounded-circle mx-auto mb-3 team-avatar">
            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($name) ?></h5>
            <p class="text-primary mb-1">MSSV: <?= htmlspecialchars($mssv) ?></p>
            <p class="text-muted small"><?= htmlspecialchars($mission) ?></p>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="about-section py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="fw-bold display-5 text-primary">
        <i class="bi bi-people-fill me-2"></i>Về chúng tôi
      </h1>
      <p class="text-muted fs-5"><?= htmlspecialchars($subtitle2) ?></p>
    </div>

    <?php if (!empty($aboutContent)): ?>
      <?= $aboutContent ?>
    <?php else: ?>
      <div class="about-content bg-white shadow-sm rounded-4 p-4 mb-5">
        <h2 class="fw-bold text-primary mb-3">BK Figure Lab - Nơi hội tụ đam mê</h2>
        <p>Chào mừng bạn đến với <strong>BK Figure Lab</strong> — cửa hàng chuyên cung cấp các sản phẩm figure, mô
          hình chính hãng chất lượng cao!</p>
        <p>Với niềm đam mê và tình yêu dành cho các sản phẩm figure, chúng tôi cam kết mang đến cho khách hàng những
          sản phẩm tốt nhất từ các thương hiệu nổi tiếng như <strong>Bandai</strong>, <strong>Good Smile
            Company</strong>, <strong>Kotobukiya</strong> và nhiều thương hiệu khác.</p>
        <h3 class="mt-4 text-secondary"><i class="bi bi-bullseye me-2"></i>Tầm nhìn</h3>
        <p>Trở thành cửa hàng figure uy tín hàng đầu Việt Nam, nơi các fan hâm mộ có thể tìm thấy những sản phẩm yêu
          thích của mình.</p>
        <h3 class="mt-4 text-secondary"><i class="bi bi-lightning-charge-fill me-2"></i>Sứ mệnh</h3>
        <p>Cung cấp sản phẩm chính hãng, chất lượng cao với giá cả hợp lý. Đồng thời tạo dựng cộng đồng người yêu
          thích figure tại Việt Nam.</p>
        <div class="text-center mt-5">
          <img src="https://picsum.photos/1000/400?random=4" alt="About BK Figure Lab" class="img-fluid rounded-4 shadow">
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<style>
  /* About Section */
  .about-section h1,
  .about-section h2,
  .about-section h3 {
    font-family: 'Segoe UI', sans-serif;
  }

  .about-content p {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #333;
  }

  .about-content strong {
    color: #007bff;
  }

  /* Team Section */
  .team-card {
    transition: all 0.3s ease;
    border-radius: 16px;
  }

  .team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .team-avatar {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border: 5px solid #007bff;
  }

  .team-section {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
  }
</style>