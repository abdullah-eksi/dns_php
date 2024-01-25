<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeXp Domain Search</title>
	
<!-- ========== Favicon Icon Start ========== -->
<link rel="shortcut icon" href="https://aexpan.com.tr/upload/webfavicons/19a25722ae.ico" type="image/x-icon">
<!-- ========== Favicon Icon Stop ========== -->

    <!-- Bootstrap CSS Link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('https://whois.aexpan.xyz/back.jpg') center/cover fixed no-repeat;
            height: 100vh;
            margin: 0;
        }
        .blur-container {
            background: url('https://whois.aexpan.xyz/back.jpg') center/cover fixed no-repeat;
            filter: blur(8px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            height: 1000vh;
        }
        section {
            margin-top: 10vh;
            margin-bottom: 10vh;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh; 
        }
        .container {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            position: relative;
            z-index: 1;
            margin-bottom: 92px;
        }
        .jumbotron {
            background-color: #4b535b;
            color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .tab-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        .nav-tabs .nav-item {
            margin-bottom: -1px;
        }
        .nav-tabs .nav-link {
            border: 1px solid #dee2e6;
            border-radius: 10px 10px 0 0;
            color: #007bff;
        }
        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: #ffffff;
            border: 1px solid #007bff;
        }
        .tab-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #sorgula-btn {
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="blur-container"></div>

    <section>
        <div class="container">
            <div class="jumbotron">
				<div style='
							    display: flex;
    align-items: center;
    justify-content: center;

							'>
				<img  style='width:200px' src='https://aexpan.com.tr/upload/weblogos/19a20872ae.webp'>
				</div>
                <h1 class="display-4 text-center"> Domain Sorgulama Aracı</h1>
                <p class="lead text-center">Aşağıdaki form aracılığıyla domain bilgilerinizi sorgulayabilirsiniz.</p>
                <hr class="my-4">
                <div class="form-container">
                    <form action="" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="domain" name="domain" placeholder="Sorgulamak istediğiniz Domaini Giriniz" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success btn-block" id="sorgula-btn">Sorgula</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $domain = isset($_GET["domain"]) ? $_GET["domain"] : "";
if (!empty($domain)) {

  function whois_query($domain) {
    $extension = strtolower(pathinfo($domain, PATHINFO_EXTENSION));

    $whois_servers = array(
        "tr" => "whois.nic.tr",
        "com" => "whois.verisign-grs.com",
        "net" => "whois.verisign-grs.com",
        "org" => "whois.pir.org",
        "xyz" => "whois.nic.xyz",
        "info" => "whois.afilias.net",
        "biz" => "whois.biz",
        "io" => "whois.nic.io",
        // Diğer uzantılar için buraya ekleyebilirsiniz
    );

    // Uzantıya göre whois sunucusunu belirle
    $whois_server = isset($whois_servers[$extension]) ? $whois_servers[$extension] : 'whois.verisign-grs.com';

    $port = 43;

    $fp = fsockopen($whois_server, $port, $errno, $errstr, 30);

    if (!$fp) {
        die('Bağlantı hatası: ' . $errstr . ' (' . $errno . ')');
    }

    $query = $domain . "\r\n";

    fwrite($fp, $query);

    $response = '';
    while (!feof($fp)) {
        $response .= fgets($fp, 128);
    }

    fclose($fp);

    return $response;
}

                $dns_records = dns_get_record($domain, DNS_ALL);

                echo "<div class='tab-container'>";
                echo "<ul class='nav nav-tabs' id='myTabs'>";
                echo "<li class='nav-item'>";
                echo "<a class='nav-link active' id='whois-tab' data-toggle='tab' href='#whois-content'>WHOIS Bilgileri</a>";
                echo "</li>";
                echo "<li class='nav-item'>";
                echo "<a class='nav-link' id='dns-tab' data-toggle='tab' href='#dns-content'>DNS Kayıtları</a>";
                echo "</li>";
                echo "</ul>";

                echo "<div class='tab-content'>";
                echo "<div class='tab-pane fade show active' id='whois-content'>";
                echo "<h2>WHOIS Bilgileri:</h2>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered'>";
                echo "<tr><th>WHOIS Bilgisi</th></tr>";
                echo "<tr><td><pre>" . nl2br(whois_query($domain)) . "</pre></td></tr>";
                echo "</table>";
                echo "</div>";
                echo "</div>";

                echo "<div class='tab-pane fade' id='dns-content'>";
                echo "<h2>DNS Kayıtları:</h2>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered'>";
                echo "<tr><th>Tip</th><th>Host</th><th>Değer</th><th>TTL</th></tr>";
                foreach ($dns_records as $record) {
                    echo "<tr><td>{$record['type']}</td><td>{$record['host']}</td><td>";

                    switch ($record['type']) {
                        case 'A':
                        case 'AAAA':
                            if (isset($record['ip'])) {
                                echo $record['ip'];
                            } elseif (isset($record['ipv6'])) {
                                echo "İpv6 : ".$record['ipv6'];
                            } elseif (isset($record['ipv4'])) {
                                echo "İpv4 : ".$record['ipv4'];
                            }
                            break;
                        case 'MX':
                            echo $record['target'] . '<br>Priority: ' . $record['pri'];
                            break;
                        case 'SOA':
                            echo "Primary DNS: {$record['mname']}<br>";
                            echo "Responsible Authority: {$record['rname']}<br>";
                            echo "Serial: {$record['serial']}<br>";
                            echo "Refresh: {$record['refresh']}<br>";
                            echo "Retry: {$record['retry']}<br>";
                            echo "Expire: {$record['expire']}<br>";
                            echo "Minimum TTL: {$record['minimum-ttl']}<br>";
                            break;
                        case 'TXT':
                            echo implode('<br>', $record['entries']);
                            break;
                        case 'NS':
                            echo "Name Server: <b style='color:red'> {$record['target']}</b><br>";
                            break;
                        default:
                            echo 'Detay eklenmemiş';
                    }

                    echo "</td><td>{$record['ttl']}</td></tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                echo "</div>";
            }
			   }else{
            echo "<div class='alert alert-info' role='alert'>Lütfen bir domain girin ve sorgulama yapın.</div>";
        }
            ?>
        </div>
    </section>

    <!-- Bootstrap JS and Popper.js (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
