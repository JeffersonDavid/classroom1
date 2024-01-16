<?php

class ModelAdd
{
    private string $model;

    public function __construct( $model )
    {
        $this->model = $model;
    }

    public function render()
    {

      
        switch ($this->model ) {
            case 'users':
                echo $this->generateUserForm();
                break;
            case 'products':
                echo $this->generateProductForm();
                break;
            default:
                break;
        }        
    }

    private function generateUserForm()
   {
        // Opciones para el rol
        $roleOptions = [
            2 => 'Administrador',
            1 => 'Cliente'
        ];

        // Generar las opciones del rol para el formulario
        $roleSelectOptions = '';
        foreach ($roleOptions as $value => $label) {
            $roleSelectOptions .= "<option value='$value'>$label</option>";
        }

        // Formulario de usuario
        return <<<HTML
            <form action="index.php?page=model-add&model_type=users" method="post">
            <h3>Crear un usuario</h3>
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" placeholder="Escriba aquí su nombre" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Escriba aquí su email" required>

                <label for="pass1">Contraseña:</label>
                <input type="password" id="pass1" name="password" placeholder="Escriba aquí su contraseña" required>

                <div style="margin:10px">
                    <label for="role">Selecciona una opción:</label>
                    <select id="role" name="role">
                        $roleSelectOptions
                    </select>
                </div>
                <input type="submit" name="Registrarse" value="Registrarse">
            </form>
        HTML;
    }



    private function generateProductForm()
    {
        
         // Formulario de usuario
         return <<<HTML
             <form action="procesar_insercion.php" method="post">
                <h3>Crear un producto</h3>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>

                <input type="submit" name="insertar" value="Insertar Producto">
            </form>
         HTML;
     }


   
    
}
