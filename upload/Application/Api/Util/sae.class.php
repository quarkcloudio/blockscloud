<?php
   /**
    * SAE 中文分词服务 
    *
    * @package sae 
    * @version $Id$
    * @author Elmer Zhang
    */
  /**
   * SAE 中文分词服务<br />
   *
   * <code>
   * <?php
   * $str = "明天星期天";
   * $seg = new SaeSegment();
   * $ret = $seg->segment($str, 1);
   *
   * print_r($ret);   //输出
   *
   * // 失败时输出错误码和错误信息
   * if ($ret === false)
   *      var_dump($seg->errno(), $seg->errmsg());
   * ?>
   * </code>
   *
   * 错误码参考：
   *  - errno 0      成功
   *  - errno -1     服务初始化出错，服务器没有正常启动
   *  - errno -2     错误的参数输入
   *  - errno -3     文本内容长度为0
   *  - errno -4     其他错误
   *  - errno 607    服务未初始化
   *
   * @package sae
   * @author Elmer Zhang
   *
   */
  class SaeSegment extends SaeObject
  {
      private $_errno = SAE_Success;
      private $_errmsg = "OK";
      private $_errmsgs = array(
              -1 => "word segmentation service internal error",
              -2 => "parameters (word_tag, encoding) error.",
              -3 => "context can not be empty",
              -4 => "unknown error",
              607 => "service is not enabled",
              );
      private $_encodings = array('GBK', 'UTF-8', 'UCS-2');
  
      /**
       * @ignore
       */
      const baseurl = "http//segment.sae.sina.com.cn/urlclient.php";
  
      /**
       * 构造对象
       *
       */
      function __construct() {
      }
  
      /**
       * 执行分词
       * 
       * @param string context 需要分词的文本，目前限制文本大小最大为10KB。
       * @param int context 用来标识返回的结果是否含有标注词性字段。0 表示不标注，1 表示标注词性，默认为0。(词性定义参见下面的常量)
       * @param string encoding 传入的文件编码格式：GB18030、UTF-8、UCS-2。默认为UTF-8
       * @return array|bool 成功以数组格式返回分词结果，失败返回false.
       * @author Elmer Zhang
       */
      function segment($context, $word_tag = 0, $encoding = 'UTF-8') {
          $post = array();
          $params = array();
  
          if ( trim( $context ) === '' ) {
              $this->_errno = -3;
              $this->_errmsg = $this->_errmsgs[-3];
              return false;
          } else {
              $post['context'] = $context;
          }
  
          $params['word_tag'] = $word_tag ? 1 : 0;
  
          $encoding = strtoupper(trim($encoding));
          if ( !in_array( $encoding, $this->_encodings ) ) {
              $params['encoding'] = 'UTF-8';
          } else {
              $params['encoding'] = $encoding;
          }
  
          $ret = $this->postData($post, $params);
          if ( $encoding != 'UTF-8' && !empty($ret) ) {
              foreach ($ret as $k => $v) {
                  $v['word'] = mb_convert_encoding( $v['word'], $encoding, 'UTF-8' );
                 $ret[$k] = $v;
             }
         }
 
         return $ret;
     }
 
     /**
      * 取得错误码
      *
      * @return int
      * @author Elmer Zhang
      */
     public function errno() {
         return $this->_errno;
     }
 
     /**
      * 取得错误信息
      *
      * @return string
      * @author Elmer Zhang
      */
     public function errmsg() {
         return $this->_errmsg;
     }
 
     private function postData($post, $params) {
         $url = selfbaseurl . '?' . http_build_query( $params );
         $s = curl_init();
         if (is_array($post)) {
             $post = http_build_query($post);
         }
         curl_setopt($s,CURLOPT_URL,$url);
         curl_setopt($s,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_0);
         curl_setopt($s,CURLOPT_TIMEOUT,5);
         curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
         curl_setopt($s,CURLINFO_HEADER_OUT, true);
         curl_setopt($s,CURLOPT_POST,true);
         curl_setopt($s,CURLOPT_POSTFIELDS,$post); 
         $ret = curl_exec($s);
         $info = curl_getinfo($s);
         curl_close($s);
 
         if(empty($info['http_code'])) {
             $this->_errno = -4;
             $this->_errmsg = "can not reach word segmentation server";
         } else if($info['http_code'] == 607) {
             $this->_errno = 607;
             $this->_errmsg = $this->_errmsgs[607];
         } else if($info['http_code'] != 200) {
             $this->_errno = -1;
             $this->_errmsg = $this->_errmsgs[-1];
         } else {
             if($info['size_download'] == 0) { // get MailError header
                 $this->_errno = SAE_ErrInternal;
                 $this->_errmsg = "word segmentation service internal error";
             } else {
                 $array = json_decode(trim($ret), true);
                 if ( count( $array ) === 1 && is_int( $array[0] ) && $array[0] < 0 ) {
                     $this->_errno = $array[0];
                     $this->_errmsg = $this->_errmsgs[$array[0]];
 
                     return false;
                 } else {
                     $this->_errno = SAE_Success;
                     $this->_errmsg = 'OK';
 
                     return $array;
                 }
             }
         }
         return false;
     }
 
     /**
      * 不知道
      */
     const POSTAG_ID_UNKNOW = 0;
 
     /**
      * 形容词
      */
     const POSTAG_ID_A = 10;
 
     /**
      * 区别词
      */
     const POSTAG_ID_B = 20;
 
     /**
      * 连词
      */
     const POSTAG_ID_C = 30;
 
     /**
      * 体词连接
      */
     const POSTAG_ID_C_N = 31;
 
     /**
      * 分句连接
      */
     const POSTAG_ID_C_Z = 32;
 
     /**
      * 副词
      */
     const POSTAG_ID_D = 40;
 
     /**
      * 副词("不")
      */
     const POSTAG_ID_D_B = 41;
 
     /**
      * 副词("没")
      */
     const POSTAG_ID_D_M = 42;
 
     /**
      * 叹词
      */
     const POSTAG_ID_E = 50;
 
     /**
      * 方位词
      */
     const POSTAG_ID_F = 60;
 
     /**
      * 方位短语(处所词+方位词)
      */
     const POSTAG_ID_F_S = 61;
 
     /**
      * 方位短语(名词+方位词“地上”)
      */
     const POSTAG_ID_F_N = 62;
 
     /**
      * 方位短语(动词+方位词“取前”)
      */
     const POSTAG_ID_F_V = 63;
 
     /**
      * 方位短语(动词+方位词“取前”)
      */
     const POSTAG_ID_F_Z = 64;
 
     /**
      * 前接成分
      */
     const POSTAG_ID_H = 70;
 
     /**
      * 数词前缀(“数”---数十)
      */
     const POSTAG_ID_H_M = 71;
 
     /**
      * 时间词前缀(“公元”“明永乐”)
      */
     const POSTAG_ID_H_T = 72;
 
     /**
      * 姓氏
      */
     const POSTAG_ID_H_NR = 73;
 
     /**
      * 姓氏
      */
     const POSTAG_ID_H_N = 74;
 
     /**
      * 后接成分
      */
     const POSTAG_ID_K = 80;
 
     /**
      * 数词后缀(“来”--,十来个)
      */
     const POSTAG_ID_K_M = 81;
 
     /**
      * 时间词后缀(“初”“末”“时”)
      */
     const POSTAG_ID_K_T = 82;
 
     /**
      * 名词后缀(“们”)
      */
     const POSTAG_ID_K_N = 83;
 
     /**
      * 处所词后缀(“苑”“里”)
      */
     const POSTAG_ID_K_S = 84;
 
     /**
      * 状态词后缀(“然”)
      */
     const POSTAG_ID_K_Z = 85;
 
     /**
      * 状态词后缀(“然”)
      */
     const POSTAG_ID_K_NT = 86;
 
     /**
      * 状态词后缀(“然”)
      */
     const POSTAG_ID_K_NS = 87;
 
     /**
      * 数词
      */
     const POSTAG_ID_M = 90;
 
     /**
      * 名词
      */
     const POSTAG_ID_N = 95;
 
     /**
      * 人名(“毛泽东”)
      */
     const POSTAG_ID_N_RZ = 96;
 
     /**
      * 机构团体(“团”的声母为t，名词代码n和t并在一起。“公司”)
      */
     const POSTAG_ID_N_T = 97;
 
     /**
      *
      */
     const POSTAG_ID_N_TA = 98;
 
     /**
      * 机构团体名("北大")
      */
     const POSTAG_ID_N_TZ = 99;
 
     /**
      * 其他专名(“专”的声母的第1个字母为z，名词代码n和z并在一起。)
      */
     const POSTAG_ID_N_Z = 100;
 
     /**
      * 名处词
      */
     const POSTAG_ID_NS = 101;
 
     /**
      * 地名(名处词专指：“中国”)
      */
     const POSTAG_ID_NS_Z = 102;
 
     /**
      * n-m,数词开头的名词(三个学生)
      */
     const POSTAG_ID_N_M = 103;
 
     /**
      * n-rb,以区别词/代词开头的名词(该学校，该生)
      */
     const POSTAG_ID_N_RB = 104;
 
     /**
      * 拟声词
      */
     const POSTAG_ID_O = 107;
 
     /**
      * 介词
      */
     const POSTAG_ID_P = 108;
 
     /**
      * 量词
      */
     const POSTAG_ID_Q = 110;
 
     /**
      * 动量词(“趟”“遍”)
      */
     const POSTAG_ID_Q_V = 111;
 
     /**
      * 时间量词(“年”“月”“期”)
      */
     const POSTAG_ID_Q_T = 112;
 
     /**
      * 货币量词(“元”“美元”“英镑”)
      */
     const POSTAG_ID_Q_H = 113;
 
     /**
      * 代词
      */
     const POSTAG_ID_R = 120;
 
     /**
      * 副词性代词(“怎么”)
      */
     const POSTAG_ID_R_D = 121;
 
     /**
      * 数词性代词(“多少”)
      */
     const POSTAG_ID_R_M = 122;
 
     /**
      * 名词性代词(“什么”“谁”)
      */
     const POSTAG_ID_R_N = 123;
 
     /**
      * 处所词性代词(“哪儿”)
      */
     const POSTAG_ID_R_S = 124;
 
     /**
      * 时间词性代词(“何时”)
      */
     const POSTAG_ID_R_T = 125;
 
     /**
      * 谓词性代词(“怎么样”)
      */
     const POSTAG_ID_R_Z = 126;
 
     /**
      * 区别词性代词(“某”“每”)
      */
     const POSTAG_ID_R_B = 127;
 
     /**
      * 处所词(取英语space的第1个字母。“东部”)
      */
     const POSTAG_ID_S = 130;
 
     /**
      * 处所词(取英语space的第1个字母。“东部”)
      */
     const POSTAG_ID_S_Z = 131;
 
     /**
      * 时间词(取英语time的第1个字母)
      */
     const POSTAG_ID_T = 132;
 
     /**
      * 时间专指(“唐代”“西周”)
      */
     const POSTAG_ID_T_Z = 133;
 
     /**
      * 助词
      */
     const POSTAG_ID_U = 140;
 
     /**
      * 定语助词(“的”)
      */
     const POSTAG_ID_U_N = 141;
 
     /**
      * 状语助词(“地”)
      */
     const POSTAG_ID_U_D = 142;
 
     /**
      * 补语助词(“得”)
      */
     const POSTAG_ID_U_C = 143;
 
     /**
      * 谓词后助词(“了、着、过”)
      */
     const POSTAG_ID_U_Z = 144;
 
     /**
      * 体词后助词(“等、等等”)
      */
     const POSTAG_ID_U_S = 145;
 
     /**
      * 助词(“所”)
      */
     const POSTAG_ID_U_SO = 146;
 
     /**
      * 标点符号
      */
     const POSTAG_ID_W = 150;
 
     /**
      * 顿号(“、”)
      */
     const POSTAG_ID_W_D = 151;
 
     /**
      * 句号(“。”)
      */
     const POSTAG_ID_W_SP = 152;
 
     /**
      * 分句尾标点(“，”“；”)
      */
     const POSTAG_ID_W_S = 153;
 
     /**
      * 搭配型标点左部
      */
     const POSTAG_ID_W_L = 154;
 
     /**
      * 搭配型标点右部(“》”“]”“）”)
      */
     const POSTAG_ID_W_R = 155;
 
     /**
      * 中缀型符号
      */
     const POSTAG_ID_W_H = 156;
 
     /**
      * 语气词(取汉字“语”的声母。“吗”“吧”“啦”)
      */
     const POSTAG_ID_Y = 160;
 
     /**
      * 及物动词(取英语动词verb的第一个字母。)
      */
     const POSTAG_ID_V = 170;
 
     /**
      * 不及物谓词(谓宾结构“剃头”)
      */
     const POSTAG_ID_V_O = 171;
 
     /**
      * 动补结构动词(“取出”“放到”)
      */
     const POSTAG_ID_V_E = 172;
 
     /**
      * 动词“是”
      */
     const POSTAG_ID_V_SH = 173;
 
     /**
      * 动词“有”
      */
     const POSTAG_ID_V_YO = 174;
 
     /**
      * 趋向动词(“来”“去”“进来”)
      */
     const POSTAG_ID_V_Q = 175;
 
     /**
      * 助动词(“应该”“能够”)
      */
     const POSTAG_ID_V_A = 176;
 
     /**
      * 状态词(不及物动词,v-o、sp之外的不及物动词)
      */
     const POSTAG_ID_Z = 180;
 
     /**
      * 语素字
      */
     const POSTAG_ID_X = 190;
 
     /**
      * 名词语素(“琥”)
      */
     const POSTAG_ID_X_N = 191;
 
     /**
      * 动词语素(“酹”)
      */
     const POSTAG_ID_X_V = 192;
 
     /**
      * 处所词语素(“中”“日”“美”)
      */
     const POSTAG_ID_X_S = 193;
 
     /**
      * 时间词语素(“唐”“宋”“元”)
      */
     const POSTAG_ID_X_T = 194;
 
     /**
      * 状态词语素(“伟”“芳”)
      */
     const POSTAG_ID_X_Z = 195;
 
     /**
      * 状态词语素(“伟”“芳”)
      */
     const POSTAG_ID_X_B = 196;
 
     /**
      * 不及物谓词(主谓结构“腰酸”“头疼”)
      */
     const POSTAG_ID_SP = 200;
 
     /**
      * 数量短语(“叁个”)
      */
     const POSTAG_ID_MQ = 201;
 
     /**
      * 代量短语(“这个”)
      */
     const POSTAG_ID_RQ = 202;
 
     /**
      * 副形词(直接作状语的形容词)
      */
     const POSTAG_ID_AD = 210;
 
     /**
      * 名形词(具有名词功能的形容词)
      */
     const POSTAG_ID_AN = 211;
 
     /**
      * 副动词(直接作状语的动词)
      */
     const POSTAG_ID_VD = 212;
 
     /**
      * 名动词(指具有名词功能的动词)
      */
     const POSTAG_ID_VN = 213;
 
     /**
      * 空格
      */
     const POSTAG_ID_SPACE = 230;
 
 }
 
?>