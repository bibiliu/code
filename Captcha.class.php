<?php
	class Captcha{
		/**
		*生成验证码
		*@param $img_w int 验证图片的宽
		*@param $img_h int 验证图片的高
		*@param $char_len 尺码长度
		*@param $font 验证字体的大小
		*/
		public function generate($img_w=100,$img_h=25,$char_len=4,$font=5){
		//生成码值，不需要0，避免与字母o冲突
			$char=array_merge(range('A','Z'),range('a','z'),range(1,9));
			$rand_keys=array_rand($char,$char_len);
			if($char_len==1){
				$rand_keys=array($rand_keys);
			}
			shuffle($rand_keys);//将保存随机数的数组打乱
			$code='';
			foreach($rand_keys as $key){
				$code.=$char($key);
			}
			//保存在seesion中
			session_start();
			$_SESSION['captcha_code']=$code;
			//写入到图片中并展示
			//1.生成画布
			$img=imageCreatTureColor($img_w,$img_h);
			//设置背景
			$bg_color=imageColorAllocate($img,0xc0,0xc0,0xc0);
			imageFill($img,0,0,$bg_color);
			//干扰像素
			for($i=0;$i<=300;++$i){
				$color=imageColorAllocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
				imageSetPixel($img,mt_rand(0,$img_w),mt_rand(0,$img_h),color);
			}
			//矩形边框
			$rect_color=imageColorAllocate($img,0xff,0xff,0xff);//白
			imgRectangle($img,0,0,$img_w-1,$img_h-1,$rect_color);
			//2.操作画布
			//设定字符串颜色
			if(mt_rand(1,2)==1){
				$str_color=imgeColorAllocate($img,0,0,0);//分配颜色为黑
			}else{
				$str_color=imageColorAllocate($img,0xff,0xff,0xff);//白
			}
			//设定字符串位置
			$font_w=imgFontWidth($font);//字体宽
			$font_h=imgFontHeight($font);//字体高
			$str_w=$font_w*$char_len;//字符串宽
			imageString($img,$font,($img_w-$str_w)/2,($img_h-$font_h)/2.$code,$str_color);
			//3输出图片内容
			header('Content-Type:image/png');
			imagepng($img);
			//4销毁画布
			imagedestroy($img);
		}
	}
?>