<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RbacSeeder::class,
            DefaultUserSeeder::class,
            CurrencySeeder::class,
            PassportKeysSeeder::class,
            CleanUploadsSeeder::class,
            UserSeeder::class,
            ColorThemeSeeder::class,
            TaskStatusSeeder::class,
            FileCategorySeeder::class,
            // Blog seeders
            BlogSeeder::class,
            // Cotización de ejemplo (web estándar) para DECORYGNACIO (PEN, IGV 18%)
            DecorygnacioStandardWebsiteQuoteSeeder::class,
            // Cotización de ejemplo (web profesional) para DECORYGNACIO (PEN, IGV 18%)
            DecorygnacioProfessionalWebsiteQuoteSeeder::class,
            // Cotización de ejemplo: Sistema de Cotizaciones y Facturación con SUNAT (PEN, sin IGV) - Selmag SAC
            SelmagSacQuoteSeeder::class,
            // Cotización de ejemplo: Página Web Corporativa (PEN, IGV 18%) - ALFEMESAC
            AlfemesacQuoteSeeder::class,
            // Cotización de ejemplo: Actualización Responsive - Sistema de Lubricación Maquinaria Pesada (PEN, IGV 18%)
            LubricacionMaquinariaPesadaQuoteSeeder::class,
            // Cotización de ejemplo: App Móvil con Sincronización Offline - Sistema de Lubricación - BETKO PERU (PEN, IGV 18%)
            BetkoPeruAppLubricacionQuoteSeeder::class,
            // Cotización de ejemplo: Instalación y configuración de Tokko Broker + sincronización agencias/vendedores/propiedades (USD, IGV 18%) - César Varela
            CesarVarelaTokkoBrokerQuoteSeeder::class,
            // Cotización: Plataforma de Aprendizaje Virtual E-Learning (PEN, IGV 18%) - Flavia Jimena
            FlaviaJimenaElearningQuoteSeeder::class,
            // Cotización: Web Agencia de Viajes y Turismo (PEN, IGV 18%) - Waldir Mendez Huaman
            WaldirMendezHuamanQuoteSeeder::class,
            // Cotización: Web SEO Optimizada + Catálogo con Sistema de Cotización + Blog WordPress (PEN, IGV 18%) - Fernando Rodríguez
            FernandoRodriguezPatronajeWebQuoteSeeder::class,
            // Cotización: Página Web Estándar para Centro Neurológico Integral (PEN, IGV 18%) - Centro Neurológico Integral
            CentroNeurologicoIntegralQuoteSeeder::class,
            // Cotización: Rediseño de Tienda Online D'gusto y sabor (PEN, IGV 18%) - D'gusto y sabor srl
            DGustoYSaborRediseñoQuoteSeeder::class,
            // Cotización: Nueva Tienda Online D'gusto y sabor - Productos Personalizados (PEN, IGV 18%) - D'gusto y sabor srl
            DGustoYSaborTiendaPersonalizadosQuoteSeeder::class,
            // Cotización: Página Web para INNOVA PERU TOURS - Agencia de Turismo (PEN, IGV 18%)
            InnovaPeruToursQuoteSeeder::class,
            // Cotización: Tienda Virtual de Tecnología - Corporación Tecnológica Romax (PEN, IGV 18%) - 10,000 productos
            RomaxTecnologiaStoreQuoteSeeder::class,
        ]);
    }
}
