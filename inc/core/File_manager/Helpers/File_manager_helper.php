<?php 
use WBW\Library\Pexels\Model\Photo;
use WBW\Library\Pexels\Model\Source;
use WBW\Library\Pexels\Provider\ApiProvider;
use WBW\Library\Pexels\Request\SearchPhotosRequest;
use WBW\Library\Pexels\Response\PhotosResponse;
use WBW\Library\Pexels\Model\User;
use WBW\Library\Pexels\Model\Video;
use WBW\Library\Pexels\Model\VideoFile;
use WBW\Library\Pexels\Model\VideoPicture;
use WBW\Library\Pexels\Request\SearchVideosRequest;
use WBW\Library\Pexels\Response\VideosResponse;

if (!function_exists("search_media_online")) {
	function search_media_online($source, $keyword, $page = 1, $per_page = 30){
		include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
		try {
			$medias = [];
			switch ($source) {
			    case 'unsplash':
			        if (get_option("fm_unsplash_status", 0) && get_option("fm_unsplash_access_key", "") != ""  && get_option("fm_unsplash_secret_key", "") != ""){
				        \Unsplash\HttpClient::init([
				            'applicationId' => get_option("fm_unsplash_access_key", ""),
				            'secret'    => get_option("fm_unsplash_secret_key", ""),
				            'callbackUrl'   => base_url(),
				            'utmSource' => get_option("website_title", "#1 Social Media Management & Analysis Platform")
				        ]);

				        $result = \Unsplash\Search::photos($keyword, $page, $per_page);

				        if(!empty($result->getResults())){
				            foreach ($result->getResults() as $key => $value) {
				                $medias[] = $value['urls']['full'];
				            }
				        }
				    }

			        break;

			    case 'pexels_photo':
			    	if (get_option("fm_pexels_status", 0) && get_option("fm_pexels_api_key", "") != ""){
				        $pexels = new ApiProvider(get_option("fm_pexels_api_key", ""));
				        $request = new SearchPhotosRequest();
				        $request->setQuery($keyword);
				        $request->setPage($page); // Optional
				        $request->setPerPage($per_page); // Optional
				        //$request->setOrientation("landscape"); // Optional
				        //$request->setSize("large"); // Optional
				        //$request->setLocale("en-US"); // Optional

				        $response = $pexels->sendRequest($request);
				        $photos = $response->getPhotos();
				        if(!empty($photos)){
				            foreach ($photos as $key => $photo) {
				                $src = $photo->getSrc();
				                $medias[] = $src->getOriginal();
				            }
				        }
				    }
			        break;

			    case 'pexels_video':
			        if (get_option("fm_pexels_status", 0) && get_option("fm_pexels_api_key", "") != ""){
				        $pexels = new ApiProvider(get_option("fm_pexels_api_key", ""));
				        $request = new SearchVideosRequest();
				        $request->setQuery($keyword);
				        $request->setPage($page); // Optional
				        $request->setPerPage($per_page); // Optional
				        //$request->setOrientation("landscape"); // Optional
				        //$request->setSize("large"); // Optional
				        //$request->setLocale("en-US"); // Optional

				        $response = $pexels->sendRequest($request);
				        $videos = $response->getVideos();
				        if(!empty($videos)){
				            foreach ($videos as $key => $video) {
				                $src = $video->getVideoFiles();
				                $medias[] = $src[0]->getLink();
				            }
				        }
				    }
			        break;

			    case 'pixabay_photo':
			        if (get_option("fm_pixabay_status", 0) && get_option("fm_pixabay_api_key", "") != ""){
				        $pixabayClient = new \Pixabay\PixabayClient([ 'key' => get_option("fm_pixabay_api_key", "") ]);
				        $result = $pixabayClient->getImages(['q' => substr($keyword, 0, 100), 'per_page' => $per_page, 'page' => $page], true);
				        if(!empty($result['hits'])){
				            foreach ($result['hits'] as $key => $value) {
				                $medias[] = $value['largeImageURL'];
				            }
				        }
				    }
			        break;

			    case 'pixabay_video':
			        if (get_option("fm_pixabay_status", 0) && get_option("fm_pixabay_api_key", "") != ""){
				        $pixabayClient = new \Pixabay\PixabayClient([ 'key' => get_option("fm_pixabay_api_key", "") ]);
				        $result = $pixabayClient->getVideos(['q' => substr($keyword, 0, 100), 'per_page' => $per_page, 'page' => $page], true);
				        if(!empty($result['hits'])){
				            foreach ($result['hits'] as $key => $value) {
				                $medias[] = $value['videos']['large']['url'];
				            }
				        }
				    }
			        break;
			    
			    default:
			        // code...
			        break;
			} 

			return $medias;
		} catch (\Exception $e) {
			throw new Exception($e->getMessage(), 1);
		}
	}
}