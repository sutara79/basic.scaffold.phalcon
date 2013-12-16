<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class ProductsController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for products
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Products", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");            
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $products = Products::find($parameters);
        if (count($products) == 0) {
            $this->flash->notice("The search did not find any products");
            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $products,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a product
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $product = Products::findFirstById($id);
            if (!$product) {
                $this->flash->error("product was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "products",
                    "action" => "index"
                ));
            }

            $this->view->id = $product->id;

            $this->tag->setDefault("id", $product->id);
            $this->tag->setDefault("type_id", $product->type_id);
            $this->tag->setDefault("name", $product->name);
            $this->tag->setDefault("price", $product->price);
            $this->tag->setDefault("quantity", $product->quantity);
            $this->tag->setDefault("status", $product->status);
            
        }
    }

    /**
     * Creates a new product
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "index"
            ));
        }

        $product = new Products();

        $product->id = $this->request->getPost("id");
        $product->type_id = $this->request->getPost("type_id");
        $product->name = $this->request->getPost("name");
        $product->price = $this->request->getPost("price");
        $product->quantity = $this->request->getPost("quantity");
        $product->status = $this->request->getPost("status");
        

        if (!$product->save()) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "new"
            ));
        }

        $this->flash->success("product was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "products",
            "action" => "index"
        ));

    }

    /**
     * Saves a product edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $product = Products::findFirstByid($id);
        if (!$product) {
            $this->flash->error("product does not exist " . $id);
            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "index"
            ));
        }

        $product->id = $this->request->getPost("id");
        $product->type_id = $this->request->getPost("type_id");
        $product->name = $this->request->getPost("name");
        $product->price = $this->request->getPost("price");
        $product->quantity = $this->request->getPost("quantity");
        $product->status = $this->request->getPost("status");
        

        if (!$product->save()) {

            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "edit",
                "params" => array($product->id)
            ));
        }

        $this->flash->success("product was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "products",
            "action" => "index"
        ));

    }

    /**
     * Deletes a product
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $product = Products::findFirstByid($id);
        if (!$product) {
            $this->flash->error("product was not found");
            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "index"
            ));
        }

        if (!$product->delete()) {

            foreach ($product->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "products",
                "action" => "search"
            ));
        }

        $this->flash->success("product was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "products",
            "action" => "index"
        ));
    }

}
