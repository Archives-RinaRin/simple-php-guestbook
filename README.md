# simple-php-guestbook

PHP 기반 간단 방명록 소스입니다. **별도의 프레임워크나 외부 라이브러리를 필요로 하지 않는** 순수(Vanilla) PHP를 기반으로 작성되었습니다.

## 설치 환경
- 최소 조건은 PHP 5.5.x이나, PHP 7.x 이상을 권장합니다. (5.5.x 이전 버전에서는 제대로 동작하지 않을 수 있습니다)
- 서버에 MySQL이나 호환되는 버전의 MariaDB가 설치되어 있어야 합니다.
- 서버에 PHP용 ```curl``` 확장기능이 세팅되어 있어야 합니다.
- 웹 호스팅을 이용중인 경우, 자신의 웹사이트가 위 조건에 맞는지 확인하려면 호스팅 서버 관리자에게 문의하세요.

## 설치방법
- [이 파일](https://github.com/Senarin/simple-php-guestbook/archive/master.zip)을 다운로드하여 적당한 곳에 압축을 해제합니다.
- 압축 해제한 폴더 내의 ```global_config.php``` 및 ```index.php```, ```master_login.php``` 파일을 자신의 서버 환경에 맞게 수정합니다.
- FTP 등을 통해 압축 해제한 폴더를 자신의 서버의 웹 루트 디렉토리에 업로드 합니다.
- 업로드한 주소로 접속하면 자동으로 테이블이 생성됩니다. (예: 자신의 서버 주소가 ```example.com```이고 업로드한 경로가 ```/guestbook/```이라면 ```http://example.com/guestbook/```로 접속해주시면 됩니다.)

## 참고사항
- 이 프로그램은 스팸 방지 기능을 위해 [reCAPTCHA v3](https://developers.google.com/recaptcha/docs/v3)을 이용하고 있습니다. [이 페이지](https://www.google.com/recaptcha/admin)로 접속하여 화면의 지침에 따라 [키를 발급받으시면 됩니다.](https://swiftcoding.org/recaptcha-api-key)
