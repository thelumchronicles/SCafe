package com.doan.scafe;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.ImageView;
import android.widget.SearchView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.squareup.picasso.Picasso;

import org.jetbrains.annotations.NotNull;

import java.io.IOException;
import java.text.Normalizer;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Pattern;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ChooseProduct extends AppCompatActivity {
    RecyclerView recyclerView;
    ChooseProductAdapter chooseProductAdapter;
    ArrayList<Product> productsAll;
    ArrayList<Product> productsOriginal;
    AlertDialog dialogTEst;
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.choose_product_layout);
        dialogTEst = new AlertDialog.Builder(ChooseProduct.this).setPositiveButton("OK", null).create();

        Button btnReSelected = findViewById(R.id.btnReSelected);
        Button btnFinished = findViewById(R.id.btnFinished);


        TextView txtTableNameDisplay = findViewById(R.id.txtTableNameDisplay);
        txtTableNameDisplay.setText(GlobalVar.currentSystemTableName);
        TextView txtCategoryNameDisplay = findViewById(R.id.txtCategoryNameDisplay);
        txtCategoryNameDisplay.setText(GlobalVar.currentSystemCategoryName);

        Toolbar toolbar = findViewById(R.id.toolBar4);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        recyclerView = findViewById(R.id.productRecyclerView);
        ArrayList<Product> products = new ArrayList<>();
        productsAll = new ArrayList<>();
        productsOriginal = new ArrayList<>();

        chooseProductAdapter = new ChooseProductAdapter(ChooseProduct.this, products , productsAll);
        GlobalVar.sCafeFunctions.getAllProducts(products,productsAll , productsOriginal, chooseProductAdapter , GlobalVar.currentSystemCategoryID );

        btnReSelected.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
               products.clear();
               productsAll.clear();
                for (Product product: productsOriginal) {
                    try {
                        products.add((Product)product.clone());

                    } catch (CloneNotSupportedException e) {
                        e.printStackTrace();
                    }
                }
                productsAll.addAll(products);
                chooseProductAdapter.notifyDataSetChanged();

            }
        });

        btnFinished.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                int indexScope = 0;

                pushDataProductsToServer(indexScope);

            }
        });



        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(this);
        DividerItemDecoration dividerItemDecoration = new DividerItemDecoration(recyclerView.getContext(),
                linearLayoutManager.getOrientation());
        recyclerView.addItemDecoration(dividerItemDecoration);
        recyclerView.setAdapter(chooseProductAdapter);
        recyclerView.setLayoutManager(linearLayoutManager);
    }

    void pushDataProductsToServer(int indexScope ){
        if (indexScope < productsAll.size()) {
            if (productsAll.get(indexScope).product_amount != 0) {
                GlobalVar.sCafeFunctions.sCafeHolderAPI.themThucDon(GlobalVar.currentSystemInvoiceID , productsAll.get(indexScope).product_id , productsAll.get(indexScope).product_amount).enqueue(new Callback<String>() {
                    @Override
                    public void onResponse(Call<String> call, Response<String> response) {
                        pushDataProductsToServer(indexScope + 1);
                        System.out.println("Thành công");
                    }

                    @Override
                    public void onFailure(Call<String> call, Throwable t) {
                        System.out.println(t.getMessage());
                    }
                });
            }
            else {
                pushDataProductsToServer(indexScope + 1);
            }

        }
        else {
            Intent chooseProductIntent = new Intent(this , OrderedTable.class);
            startActivity(chooseProductIntent);
            GlobalVar.sCafeFunctions.updateDataFromFragments();
            finish();
        }

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        getMenuInflater().inflate(R.menu.searchcategory_menu, menu);
        MenuItem item = menu.findItem(R.id.action_search);
        SearchView searchView = (SearchView)item.getActionView();
        searchView.setIconified(false);
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                chooseProductAdapter.getFilter().filter(newText);
                return false;
            }
        });


        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                onBackPressed();
                return true;

            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    public void onBackPressed() {
        super.onBackPressed();
        Intent myIntent = new Intent(ChooseProduct.this, OrderedTable.class);
        startActivity(myIntent);
        finish();
    }
}


class ChooseProductAdapter extends RecyclerView.Adapter<ChooseProductAdapter.ViewHolder> implements Filterable {


    ArrayList<Product> products;
    ArrayList<Product> productsAll;
    LayoutInflater inflater;

    public ChooseProductAdapter(Context ctx, ArrayList<Product> products , ArrayList<Product> productsAll) {
        this.products = products;
        this.productsAll = productsAll;
        this.inflater = LayoutInflater.from(ctx);
    }


    @NonNull
    @NotNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.choose_product_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull @NotNull ViewHolder holder, int position) {
        holder.txtProductName.setText(products.get(position).product_name);
        holder.txtProductPrice.setText(String.valueOf(products.get(position).product_price));

        holder.checkBox.setChecked(false);
        holder.buttonIncrease.setVisibility(View.GONE);
        holder.buttonDecrease.setVisibility(View.GONE);
        holder.amount.setVisibility(View.GONE);

        if (products.get(position).product_amount != 0){
            holder.checkBox.setChecked(true);
            holder.buttonIncrease.setVisibility(View.VISIBLE);
            holder.buttonDecrease.setVisibility(View.VISIBLE);
            holder.amount.setVisibility(View.VISIBLE);

        }
        holder.amount.setText(String.valueOf(products.get(position).product_amount));

        holder.checkBox.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (holder.checkBox.isChecked()) {
                    holder.buttonIncrease.setVisibility(View.VISIBLE);
                    holder.buttonDecrease.setVisibility(View.VISIBLE);
                    holder.amount.setVisibility(View.VISIBLE);

                    Product tempProduct = products.get(position);
                    tempProduct.product_amount = 1;
                    products.set(position,tempProduct);

                    holder.amount.setText(String.valueOf(tempProduct.product_amount));



                }
                else {
                    holder.buttonIncrease.setVisibility(View.GONE);
                    holder.buttonDecrease.setVisibility(View.GONE);
                    holder.amount.setVisibility(View.GONE);
                    Product tempProduct = products.get(position);
                    tempProduct.product_amount = 0;
                    products.set(position,tempProduct);
                    holder.amount.setText(String.valueOf(tempProduct.product_amount));
                }
            }
        });

        holder.buttonIncrease.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Product tempProduct = products.get(position);
                tempProduct.product_amount += 1;
                products.set(position,tempProduct);
                holder.amount.setText(String.valueOf(tempProduct.product_amount));
            }
        });

        holder.buttonDecrease.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Product tempProduct = products.get(position);
                if (tempProduct.product_amount > 1) {
                    tempProduct.product_amount -= 1;
                    products.set(position,tempProduct);
                    holder.amount.setText(String.valueOf(tempProduct.product_amount));
                }

            }
        });


        Picasso.get().load(GlobalVar.baseBackendURL + products.get(position).product_image).transform(new CircleTransform()).into(holder.imgProduct);
    }

    @Override
    public int getItemCount() {
        return products.size();
    }

    @Override
    public Filter getFilter() {

        return categoriesFilter;
    }


    public static String deAccent(String str) {
        String nfdNormalizedString = Normalizer.normalize(str, Normalizer.Form.NFD);
        Pattern pattern = Pattern.compile("\\p{InCombiningDiacriticalMarks}+");
        return pattern.matcher(nfdNormalizedString).replaceAll("");
    }

    private Filter categoriesFilter = new Filter() {
        @Override
        protected FilterResults performFiltering(CharSequence constraint) {

            List<Product> filteredProducts = new ArrayList<>();
            filteredProducts.addAll(productsAll);
            filteredProducts.clear();
            if (constraint == null || constraint.length() == 0){
                filteredProducts.addAll(productsAll);
            }
            else {
                String filterPattern = constraint.toString().toLowerCase().trim();

                for (Product product : products ) {
                    if (deAccent(product.product_name.toLowerCase()).contains(deAccent(filterPattern))) {
                        filteredProducts.add(product);
                    }

                }
            }
            FilterResults results = new FilterResults();
            results.values = filteredProducts;
            return results;
        }

        @Override
        protected void publishResults(CharSequence constraint, FilterResults results) {
            products.clear();
            products.addAll((List) results.values);
            notifyDataSetChanged();
        }
    };

    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView txtProductName;
        TextView txtProductPrice;
        ImageView imgProduct;
        CheckBox checkBox;
        Button buttonIncrease;
        Button buttonDecrease;
        EditText amount;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            txtProductName = itemView.findViewById(R.id.txtDiscountCode);
            txtProductPrice = itemView.findViewById(R.id.txtDiscountDes);
            imgProduct = itemView.findViewById(R.id.imgProduct);
            checkBox = itemView.findViewById(R.id.checkBox);
            buttonDecrease = itemView.findViewById(R.id.buttonDecrease);
            buttonIncrease = itemView.findViewById(R.id.buttonIncrease);
            amount = itemView.findViewById(R.id.amount);
        }
    }
}

