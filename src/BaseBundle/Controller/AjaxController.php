<?php

// src/BaseBundle/Controller/AjaxController.php
namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    // Page register
    public function add_checkbox_superAdmin_Action(Request $request)
    {
        $request = $this->container->get('request');        
        $data1 = $request->query->get('data1');
      
        $response = array("code" => 100, "success" => true);
        return new Response(json_encode($response));


        // The search term from the autocomplete input
        $query = $request->query->get('q', '');
        
        $choice_loader = new ChoiceLoader(false);
        $choice_list = $choice_loader->getChoicesList($query);
        $list_values = [ ];
        
        // Dummy entry for the search term, allows creating new values

        if (strlen($query) > 0)
        {
            $list_values[ ] =
            [
                'id' => 'create:' . $query,
                'text' => $query . ' *'
            ];
        }
        
        // Add regular entries
        
        foreach ($choice_list as $label => $id)
        {
            $list_values[ ] =
            [   
                'id' => $id,
                'text' => $label
            ];
        }
                
        $response = new JsonResponse();
        $response->setData([ 'results' => $list_values ]);
        
        return $response;
    
    }

    //
    public function get_subjectsAction(Request $request)
    {                           
        $response = array("code" => 100, "success" => true, "motif1" => "Flebeleb", "motif2" => "Mouarf", "motif3" => "MesCouilles");
        return new Response(json_encode($response)); //echo json_encode($array);
    }
}