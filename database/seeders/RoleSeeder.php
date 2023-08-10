<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * 
         * SUPER ADMIN => All
         * GERENTE => All
         * SUBGERENTE => Indicadores, Caja, Inversiones
         * ASISTENTE ADMINISRATIVO => Caja, Caja Chica, Viaticos
         */

        $super_admin = Role::create(['name'=>'Super Admin']);
        $gerente = Role::create(['name'=>'Gerente']);
        $subgerete = Role::create(['name'=>'Subgerente']);
        $asistente_administrativo = Role::create(['name'=>'Asistente Administrativo']);

        //DASHBOARD
        Permission::create(['name' => 'indicadores'])->syncRoles([$super_admin, $gerente, $subgerete]);

        //ROLES
        Permission::create(['name' => 'roles.index'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'roles.create'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'roles.store'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'roles.show'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'roles.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'roles.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'roles.delete'])->syncRoles([$super_admin, $gerente]);

        //USUARIOS
        Permission::create(['name' => 'usuarios.index'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'usuarios.create'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'usuarios.store'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'usuarios.show'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'usuarios.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'usuarios.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'usuarios.delete'])->syncRoles([$super_admin, $gerente]);

        //PROYECTOS
        Permission::create(['name' => 'proyectos.index'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'proyectos.create'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'proyectos.store'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'proyectos.show'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'proyectos.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'proyectos.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'proyectos.delete'])->syncRoles([$super_admin, $gerente]);

        //CATEGORIAS GLOBALES
        Permission::create(['name' => 'categorias-globales.index'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'categorias-globales.create'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'categorias-globales.store'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'categorias-globales.show'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'categorias-globales.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'categorias-globales.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'categorias-globales.delete'])->syncRoles([$super_admin, $gerente]);

        //CAJAS
        Permission::create(['name' => 'cajas.index'])->syncRoles([$super_admin, $gerente, $subgerete, $asistente_administrativo]);
        Permission::create(['name' => 'cajas.create'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'cajas.store'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'cajas.show'])->syncRoles([$super_admin, $gerente, $subgerete, $asistente_administrativo]);
        Permission::create(['name' => 'cajas.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'cajas.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'cajas.delete'])->syncRoles([$super_admin, $gerente]);

        //CONTROL CAJA
        Permission::create(['name' => 'control-cajas.index'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'control-cajas.create'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'control-cajas.store'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'control-cajas.show'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'control-cajas.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'control-cajas.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'control-cajas.delete'])->syncRoles([$super_admin, $gerente]);

        //PRESTAMOS INTERNOS
        Permission::create(['name' => 'prestamos-internos.index'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'prestamos-internos.create'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'prestamos-internos.store'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'prestamos-internos.show'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'prestamos-internos.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'prestamos-internos.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'prestamos-internos.delete'])->syncRoles([$super_admin, $gerente]);

        //INVERSIONES
        Permission::create(['name' => 'inversiones.index'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'inversiones.create'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'inversiones.store'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'inversiones.show'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'inversiones.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'inversiones.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'inversiones.delete'])->syncRoles([$super_admin, $gerente]);

        //CAJA CHICA
        Permission::create(['name' => 'caja-chica.index'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'caja-chica.create'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'caja-chica.store'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'caja-chica.show'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'caja-chica.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'caja-chica.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'caja-chica.delete'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'caja-chica.sustentar'])->syncRoles([$super_admin, $gerente]);

        //VIATICOS
        Permission::create(['name' => 'viaticos.index'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'viaticos.create'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'viaticos.store'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'viaticos.show'])->syncRoles([$super_admin, $gerente, $asistente_administrativo]);
        Permission::create(['name' => 'viaticos.edit'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'viaticos.update'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'viaticos.delete'])->syncRoles([$super_admin, $gerente]);
        Permission::create(['name' => 'viaticos.sustentar'])->syncRoles([$super_admin, $gerente]);

        //OTROS
        Permission::create(['name' => 'lista-provincias'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'lista-distritos'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'lista-categorias-globales'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'lista-proyectos'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'generar-pdf'])->syncRoles([$super_admin, $gerente]);
    }
}
