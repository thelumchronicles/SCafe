package com.doan.scafe;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.chip.Chip;
import com.google.android.material.chip.ChipGroup;
import com.google.gson.JsonObject;

import java.net.CookieManager;
import java.net.CookiePolicy;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;

import okhttp3.JavaNetCookieJar;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;
import retrofit2.converter.scalars.ScalarsConverterFactory;

public class SCafeFunctions {
    Retrofit retrofit;
    CookieManager cookieManager;
    OkHttpClient.Builder oktHttpClient;
    SCafeHolderAPI sCafeHolderAPI;
    public SCafeFunctions(){
        //Retrofit setup with cookie (use to handle session of laravel backend)
        InitRetrofitWithCookie(GlobalVar.baseBackendURLApi);
        getCSRFToken();
    }



    void getCSRFToken(){
        sCafeHolderAPI.getCSRF().enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                GlobalVar.csrfToken = response.body();
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });
    }



    void InitRetrofitWithCookie(String baseUrl){
        cookieManager = new CookieManager();
        cookieManager.setCookiePolicy(CookiePolicy.ACCEPT_ALL);
        oktHttpClient = new OkHttpClient.Builder();
        oktHttpClient.cookieJar(new JavaNetCookieJar(cookieManager));
        retrofit = new Retrofit.Builder()
                .baseUrl(baseUrl)
                .addConverterFactory(ScalarsConverterFactory.create())
                .addConverterFactory(GsonConverterFactory.create())
                .client(oktHttpClient.build())
                .build();
        sCafeHolderAPI = retrofit.create(SCafeHolderAPI.class);
    }


    void login(Context context , String userName , String userPassword){
        AlertDialog alertDialog = new AlertDialog.Builder(context).create();
        alertDialog.setTitle("Lỗi");
        sCafeHolderAPI.login(new Credentials(userName, userPassword)).enqueue(new Callback<String>() {

            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                if (response.body().equals("Success")) {
                    getLoggedDetail(context);
                }
                else {
                    alertDialog.setMessage(response.body());
                    alertDialog.show();
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });

    }



    void getLoggedDetail(Context context){
        sCafeHolderAPI.getLoggedDetail().enqueue(new Callback<LoggedDetail>() {
            @Override
            public void onResponse(Call<LoggedDetail> call, Response<LoggedDetail> response) {
                LoggedDetail loggedDetail = response.body();
                loggedDetail.setGlobarVar();

                Intent myIntent = new Intent(context, MainActivity.class);
                context.startActivity(myIntent);
                ((Activity)context).finish();
            }

            @Override
            public void onFailure(Call<LoggedDetail> call, Throwable t) {

            }
        });
    }



    void ChangePassword(AlertDialog changePasswordDialog , String oldPassword , String newPassword , String reNewPassword) {
        if (!newPassword.equals(reNewPassword)) {
            changePasswordDialog.setMessage("Mật khẩu mới không trùng nhau");
            changePasswordDialog.show();
        }
        else {
            sCafeHolderAPI.postChangePassword(new ChangePassword(oldPassword,newPassword)).enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {
                    if (response.body().equals("Success")){
                        changePasswordDialog.setMessage("Sửa mật khẩu thành công");
                    }
                    else {
                        changePasswordDialog.setMessage(response.body());
                    }
                    changePasswordDialog.show();
                }

                @Override
                public void onFailure(Call<String> call, Throwable t) {
                    changePasswordDialog.setMessage(t.getMessage());
                    changePasswordDialog.show();
                }
            });
        }
    }



    void HandleRoomChipClick(Context context , Room room , ArrayList<Table> tables , Frag1Adapter frag1Adapter , boolean chipIsChecked){
        int shortAnimationDuration = ((Activity) context).getResources().getInteger(android.R.integer.config_shortAnimTime);
        RecyclerView recyclerView = (RecyclerView)((Activity) context).findViewById(R.id.recyclerView);

        //Filter
        if (!chipIsChecked) {
            getTables(tables,frag1Adapter);
        }
        else {

            recyclerView.setVisibility(View.GONE);
            recyclerView.setAlpha(0f);

            ((Activity) context).findViewById(R.id.recyclerView).setVisibility(View.GONE);
            ((Activity) context).findViewById(R.id.loadingPanel).setVisibility(View.VISIBLE);
            sCafeHolderAPI.getTablesWithRoomID(room.room_id).enqueue(new Callback<List<Table>>() {
                @Override
                public void onResponse(Call<List<Table>> call, Response<List<Table>> response) {
                    tables.clear();
                    tables.addAll(response.body());
                    frag1Adapter.notifyDataSetChanged();
                    ((Activity) context).findViewById(R.id.loadingPanel).setVisibility(View.GONE);
                }

                @Override
                public void onFailure(Call<List<Table>> call, Throwable t) {

                    ((Activity) context).findViewById(R.id.loadingPanel).setVisibility(View.GONE);
                }
            });
        }
        recyclerView.setVisibility(View.VISIBLE);
        recyclerView.animate()
                .alpha(1f)
                .setDuration(shortAnimationDuration)
                .setListener(null);




    }


    void getRooms(Context context , ArrayList<Table> tables , Frag1Adapter frag1Adapter){


        sCafeHolderAPI.getRooms().enqueue(new Callback<List<Room>>() {
            @Override
            public void onResponse(Call<List<Room>> call, Response<List<Room>> response) {
                ChipGroup roomSelection = (ChipGroup) ((Activity) context).findViewById(R.id.roomSelection);
                for (Room room: response.body()) {
                    Chip chip = new Chip(context);
                    chip.setText(room.room_name);
                    chip.setCheckable(true);
                    chip.setOnClickListener(new View.OnClickListener() {

                        @Override
                        public void onClick(View v) {
                            HandleRoomChipClick(context,room,tables,frag1Adapter,chip.isChecked());
                        }
                    });
                    roomSelection.addView(chip);
                }
            }

            @Override
            public void onFailure(Call<List<Room>> call, Throwable t) {

            }
        });
    }

    void getTables(ArrayList<Table> tables , Frag1Adapter frag1Adapter){

        sCafeHolderAPI.getTables().enqueue(new Callback<List<Table>>() {
            @Override
            public void onResponse(Call<List<Table>> call, Response<List<Table>> response) {
                tables.clear();
                tables.addAll(response.body());
                frag1Adapter.notifyDataSetChanged();
            }

            @Override
            public void onFailure(Call<List<Table>> call, Throwable t) {

            }
        });

    }

    void getRooms2(Context context , ArrayList<Table> tables , Frag2Adapter frag2Adapter){


        sCafeHolderAPI.getRooms().enqueue(new Callback<List<Room>>() {
            @Override
            public void onResponse(Call<List<Room>> call, Response<List<Room>> response) {
                ChipGroup roomSelection = (ChipGroup) ((Activity) context).findViewById(R.id.roomSelection2);
                for (Room room: response.body()) {
                    Chip chip = new Chip(context);
                    chip.setText(room.room_name);
                    chip.setCheckable(true);
                    chip.setOnClickListener(new View.OnClickListener() {

                        @Override
                        public void onClick(View v) {
                            HandleRoomChipClick2(context,room,tables,frag2Adapter,chip.isChecked());
                        }
                    });
                    roomSelection.addView(chip);
                }
            }

            @Override
            public void onFailure(Call<List<Room>> call, Throwable t) {

            }
        });
    }

    void getTables2(ArrayList<Table> tables , Frag2Adapter frag2Adapter){

        sCafeHolderAPI.getTablesWithStatus(1).enqueue(new Callback<List<Table>>() {
            @Override
            public void onResponse(Call<List<Table>> call, Response<List<Table>> response) {
                tables.clear();
                tables.addAll(response.body());
                frag2Adapter.notifyDataSetChanged();
            }

            @Override
            public void onFailure(Call<List<Table>> call, Throwable t) {

            }
        });

    }

    void HandleRoomChipClick2(Context context, Room room , ArrayList<Table> tables , Frag2Adapter frag2Adapter , boolean chipIsChecked){
        int shortAnimationDuration = ((Activity) context).getResources().getInteger(android.R.integer.config_shortAnimTime);
        RecyclerView recyclerView = (RecyclerView)((Activity) context).findViewById(R.id.recyclerView2);

        //Filter
        if (!chipIsChecked) {
            getTables2(tables,frag2Adapter);
        }
        else {

            recyclerView.setVisibility(View.GONE);
            recyclerView.setAlpha(0f);

            ((Activity) context).findViewById(R.id.recyclerView2).setVisibility(View.GONE);
            ((Activity) context).findViewById(R.id.loadingPanel2).setVisibility(View.VISIBLE);
            sCafeHolderAPI.getTablesWithStatusAndRoomID(room.room_id,1).enqueue(new Callback<List<Table>>() {
                @Override
                public void onResponse(Call<List<Table>> call, Response<List<Table>> response) {
                    tables.clear();
                    tables.addAll(response.body());
                    frag2Adapter.notifyDataSetChanged();
                    ((Activity) context).findViewById(R.id.loadingPanel2).setVisibility(View.GONE);
                }

                @Override
                public void onFailure(Call<List<Table>> call, Throwable t) {

                    ((Activity) context).findViewById(R.id.loadingPanel2).setVisibility(View.GONE);
                }
            });
        }
        recyclerView.setVisibility(View.VISIBLE);
        recyclerView.animate()
                .alpha(1f)
                .setDuration(shortAnimationDuration)
                .setListener(null);


    }


    //Fragment 3
    void getRooms3(Context context , ArrayList<Table> tables , Frag3Adapter frag3Adapter){


        sCafeHolderAPI.getRooms().enqueue(new Callback<List<Room>>() {
            @Override
            public void onResponse(Call<List<Room>> call, Response<List<Room>> response) {
                ChipGroup roomSelection = (ChipGroup) ((Activity) context).findViewById(R.id.roomSelection3);
                for (Room room: response.body()) {
                    Chip chip = new Chip(context);
                    chip.setText(room.room_name);
                    chip.setCheckable(true);
                    chip.setOnClickListener(new View.OnClickListener() {

                        @Override
                        public void onClick(View v) {
                            HandleRoomChipClick3(context,room,tables,frag3Adapter,chip.isChecked());
                        }
                    });
                    roomSelection.addView(chip);
                }
            }

            @Override
            public void onFailure(Call<List<Room>> call, Throwable t) {

            }
        });
    }

    void getTables3(ArrayList<Table> tables3 , Frag3Adapter frag3Adapter){

        sCafeHolderAPI.getTablesWithStatus(0).enqueue(new Callback<List<Table>>() {
            @Override
            public void onResponse(Call<List<Table>> call, Response<List<Table>> response) {
                tables3.clear();
                tables3.addAll(response.body());
                frag3Adapter.notifyDataSetChanged();
            }

            @Override
            public void onFailure(Call<List<Table>> call, Throwable t) {

            }
        });

    }

    void HandleRoomChipClick3(Context context , Room room , ArrayList<Table> tables , Frag3Adapter frag3Adapter , boolean chipIsChecked){
        int shortAnimationDuration = ((Activity) context).getResources().getInteger(android.R.integer.config_shortAnimTime);
        RecyclerView recyclerView = (RecyclerView)((Activity) context).findViewById(R.id.recyclerView3);

        //Filter
        if (!chipIsChecked) {
            getTables3(tables,frag3Adapter);
        }
        else {

            recyclerView.setVisibility(View.GONE);
            recyclerView.setAlpha(0f);

            ((Activity) context).findViewById(R.id.recyclerView3).setVisibility(View.GONE);
            ((Activity) context).findViewById(R.id.loadingPanel3).setVisibility(View.VISIBLE);
            sCafeHolderAPI.getTablesWithStatusAndRoomID(room.room_id,0).enqueue(new Callback<List<Table>>() {
                @Override
                public void onResponse(Call<List<Table>> call, Response<List<Table>> response) {
                    tables.clear();
                    tables.addAll(response.body());
                    frag3Adapter.notifyDataSetChanged();
                    ((Activity) context).findViewById(R.id.loadingPanel3).setVisibility(View.GONE);
                }

                @Override
                public void onFailure(Call<List<Table>> call, Throwable t) {

                    ((Activity) context).findViewById(R.id.loadingPanel3).setVisibility(View.GONE);
                }
            });
        }
        recyclerView.setVisibility(View.VISIBLE);
        recyclerView.animate()
                .alpha(1f)
                .setDuration(shortAnimationDuration)
                .setListener(null);


    }


    void getProductCategories(ArrayList<Category> categories , ArrayList<Category> categoriesAll, ChooseCategoryAdapter chooseCategoryAdapter){
        sCafeHolderAPI.getProductCategories().enqueue(new Callback<List<Category>>() {
            @Override
            public void onResponse(Call<List<Category>> call, Response<List<Category>> response) {
                categories.clear();
                categoriesAll.clear();
                Category categoryAll = new Category();
                categoryAll.category_id = -1;
                categoryAll.category_name = "Tất cả";
                categories.add(categoryAll);
                categories.addAll(response.body());
                categoriesAll.addAll(response.body());
                chooseCategoryAdapter.notifyDataSetChanged();
            }

            @Override
            public void onFailure(Call<List<Category>> call, Throwable t) {

            }
        });
    }

    void getAllProducts(ArrayList<Product> products, ArrayList<Product> productsAll , ArrayList<Product> productsOriginal,ChooseProductAdapter chooseProductAdapter , int category_id){
        sCafeHolderAPI.getAllProducts(category_id).enqueue(new Callback<List<Product>>() {
            @Override
            public void onResponse(Call<List<Product>> call, Response<List<Product>> response) {

                for (Product product: response.body()) {
                    try {
                        productsOriginal.add((Product)product.clone());
                    } catch (CloneNotSupportedException e) {
                        e.printStackTrace();
                    }
                }

                productsAll.clear();
                products.addAll(response.body());
                productsAll.addAll(response.body());
                chooseProductAdapter.notifyDataSetChanged();
            }

            @Override
            public void onFailure(Call<List<Product>> call, Throwable t) {

            }
        });
    }

    void getTableDetail(TextView invoice_code , TextView txtTotalMoney , TextView txtChooseVoucher , TextView txtDiscount){
        sCafeHolderAPI.getTableDetail(GlobalVar.currentSystemTableID).enqueue(new Callback<TableDetail>() {
            @Override
            public void onResponse(Call<TableDetail> call, Response<TableDetail> response) {
                TableDetail tableDetail = response.body();
                GlobalVar.currentSystemInvoiceName = "invoice - scafe" + tableDetail.invoice_id;

                invoice_code.setText("invoice - scafe" + tableDetail.invoice_id);
                GlobalVar.currentTotalPrice = tableDetail.final_price ;
                txtTotalMoney.setText(String.valueOf("Tổng tiền: " + tableDetail.final_price + "đ"));
                if (tableDetail.discount_code == null){
                    txtChooseVoucher.setText("Chọn mã >");
                    txtDiscount.setVisibility(View.GONE);
                }
                else {
                    txtChooseVoucher.setText(tableDetail.discount_code + " | " + tableDetail.discount_percent + "%");
                    txtDiscount.setVisibility(View.VISIBLE);
                }

                txtDiscount.setText("Giảm giá: -" + tableDetail.discount_price + "đ");

                GlobalVar.currentSystemInvoiceID = tableDetail.invoice_id;
            }

            @Override
            public void onFailure(Call<TableDetail> call, Throwable t) {

            }
        });
    }

    void getProductsInTable(ArrayList<ProductInTable> products , OrderedTableAdapter orderedTableAdapter){
        sCafeHolderAPI.getProductsInTable(GlobalVar.currentSystemTableID).enqueue(new Callback<List<ProductInTable>>() {
            @Override
            public void onResponse(Call<List<ProductInTable>> call, Response<List<ProductInTable>> response) {
                products.clear();
                products.addAll(response.body());
                orderedTableAdapter.notifyDataSetChanged();
            }

            @Override
            public void onFailure(Call<List<ProductInTable>> call, Throwable t) {

            }
        });
    }

    void increaseProduct(Context context , int id , ArrayList<ProductInTable> products , OrderedTableAdapter orderedTableAdapter, TextView invoice_code , TextView txtTotalMoney , TextView txtChooseVoucher , TextView txtDiscount){
        ProgressDialog progressDialog = ProgressDialog.show(context, "",
                "Loading. Please wait...", true);


        sCafeHolderAPI.increaseAmount(id,GlobalVar.currentSystemInvoiceID).enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                getProductsInTable(products,orderedTableAdapter);
                getTableDetail(invoice_code,txtTotalMoney,txtChooseVoucher, txtDiscount);
                progressDialog.dismiss();
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                progressDialog.dismiss();


            }
        });
    }

    void decreaseProduct(Context context , int id , ArrayList<ProductInTable> products , OrderedTableAdapter orderedTableAdapter , TextView invoice_code , TextView txtTotalMoney , TextView txtChooseVoucher , TextView txtDiscount){
        ProgressDialog progressDialog = ProgressDialog.show(context, "",
                "Loading. Please wait...", true);
        sCafeHolderAPI.decreaseAmount(id,GlobalVar.currentSystemInvoiceID).enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                getProductsInTable(products,orderedTableAdapter);
                getTableDetail(invoice_code,txtTotalMoney,txtChooseVoucher, txtDiscount);
                progressDialog.dismiss();
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                progressDialog.dismiss();

            }
        });
    }

    void deleteProduct(Context context , int id , ArrayList<ProductInTable> products , OrderedTableAdapter orderedTableAdapter , TextView invoice_code , TextView txtTotalMoney , TextView txtChooseVoucher , TextView txtDiscount){
        ProgressDialog progressDialog = ProgressDialog.show(context, "",
                "Loading. Please wait...", true);
        sCafeHolderAPI.deleteProduct(id,GlobalVar.currentSystemInvoiceID).enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                getProductsInTable(products,orderedTableAdapter);
                getTableDetail(invoice_code,txtTotalMoney,txtChooseVoucher, txtDiscount);
                progressDialog.dismiss();
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                progressDialog.dismiss();

            }
        });
    }

    void getDiscounts(ArrayList<Discount> discounts , DiscountAdapter discountAdapter){
        sCafeHolderAPI.getDiscounts(GlobalVar.currentSystemInvoiceID).enqueue(new Callback<List<Discount>>() {
            @Override
            public void onResponse(Call<List<Discount>> call, Response<List<Discount>> response) {
                discounts.clear();
                discounts.addAll(response.body());
                discountAdapter.notifyDataSetChanged();
            }

            @Override
            public void onFailure(Call<List<Discount>> call, Throwable t) {

            }
        });
    }

    void setDiscount(int discount_id, ArrayList<Discount> discounts , DiscountAdapter discountAdapter){
        sCafeHolderAPI.setDiscount(discount_id , GlobalVar.currentSystemInvoiceID).enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {

                OrderedTable.resetTableDetail();
                getDiscounts(discounts,discountAdapter);

            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });
    }

    void resetDiscount(){
        sCafeHolderAPI.resetDiscount(GlobalVar.currentSystemInvoiceID).enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                OrderedTable.resetTableDetail();
                DiscountActivity.resetDiscountList();
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });
    }

    void updateDataFromFragments(){

        if (GlobalVar.viewPager.getCurrentItem() == 0) {
            Tab1.updateData();
        }
        if (GlobalVar.viewPager.getCurrentItem() == 1) {
            Tab2.updateData();
        }

        if (GlobalVar.viewPager.getCurrentItem() == 2) {
            Tab3.updateData();
        }

    }

    void getSeparateTable(int table_id , Context context) {
        AlertDialog alertDialog = new AlertDialog.Builder(context).create();
        alertDialog.setTitle("Lỗi");
        alertDialog.setMessage("Mã QR không hợp lệ");
        sCafeHolderAPI.getSeparateTable(table_id).enqueue(new Callback<Table>() {
            @Override
            public void onResponse(Call<Table> call, Response<Table> response) {
                Table tableObject = response.body();
                if (tableObject == null) {
                    alertDialog.show();
                }
                else {
                    GlobalVar.currentSystemTableName = tableObject.atable_name;
                    GlobalVar.currentSystemTableID = tableObject.atable_id;
                    if (tableObject.status == 0){
                        GlobalVar.sCafeFunctions.sCafeHolderAPI.prepareTable(tableObject.atable_id).enqueue(new Callback<String>() {
                            @Override
                            public void onResponse(Call<String> call, Response<String> response) {
                                Intent orderedTable = new Intent(context, OrderedTable.class);
                                context.startActivity(orderedTable);

                            }

                            @Override
                            public void onFailure(Call<String> call, Throwable t) {

                            }
                        });

                    }
                    else {
                        Intent orderedTable = new Intent(context, OrderedTable.class);
                        context.startActivity(orderedTable);


                    }
                }
            }

            @Override
            public void onFailure(Call<Table> call, Throwable t) {
                alertDialog.setMessage("Có lỗi xảy ra!");
                alertDialog.show();
            }
        });
    }

    void thanhToan(Context context){
        sCafeHolderAPI.thanhToan(GlobalVar.currentSystemInvoiceID).enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                Intent myIntent = new Intent(context, PaySuccessful.class);
                context.startActivity(myIntent);
                ((Activity)context).finish();
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                System.out.print(t.getMessage());
            }
        });
    }







}
